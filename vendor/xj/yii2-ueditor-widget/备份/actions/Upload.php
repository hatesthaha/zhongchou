<?php

namespace xj\ueditor\actions;

use Yii;
use yii\helpers\Json;
use yii\base\Action;

class Upload extends Action {

    /**
     * 上传基本目录
     * @var string 
     */
    public $uploadBasePath = '@webroot/upload';
    public $uploadBaseUrl = '@web/upload';
    public $csrf = true;

    /**
     *
      {filename} 会替换成原文件名,配置这项需要注意中文乱码问题
      {rand:6} 会替换成随机数,后面的数字是随机数的位数
      {time} 会替换成时间戳
      {yyyy} 会替换成四位年份
      {yy} 会替换成两位年份
      {mm} 会替换成两位月份
      {dd} 会替换成两位日期
      {hh} 会替换成两位小时
      {ii} 会替换成两位分钟
      {ss} 会替换成两位秒
      非法字符 \ : * ? " < > |
     * @var type
     */
    public $pathFormat = [
        'imagePathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'scrawlPathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'snapscreenPathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'catcherPathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'snapscreenPathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'catcherPathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'videoPathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
        'filePathFormat' => '{yyyy}{mm}{dd}/{time}{rand:6}',
    ];
    public $configPatch = [
        'imageManagerListPath' => '/', //图片列表
        'fileManagerListPath' => '/', //文件列表
    ];

    /**
     * config.json to Array
     * @var array 
     */
    public $config = [];
    public $action; //request action name
    public $jsonpCallback; //jsonp name
    /**
     * 当前目录
     * @var string 
     */
    public $currentPath;

    /**
     *
     * @var []
     */
    public $result;

    /**
     * throw yii\base\Exception will break
     * @var Closure
     * beforeValidate($Upload)
     */
    public $beforeUpload;

    /**
     * throw yii\base\Exception will break
     * @var Closure
     * afterSave($Upload)
     */
    public $afterUpload;

    public function init() {
        //csrf状态
        Yii::$app->request->enableCsrfValidation = $this->csrf;
        Yii::$app->request->enableCookieValidation = $this->csrf;
        //当前目录
        $this->currentPath = dirname(__FILE__);
        return parent::init();
    }

    public function run() {
        //加载配置
        $this->loadConfig();
        //对配置进行定制
        $this->patchConfig();

        $result = $this->selector();

        /* 输出结果 */
        if ($this->jsonpCallback) {
            if (preg_match("/^[\w_]+$/", $this->jsonpCallback)) {
                $result = htmlspecialchars($this->jsonpCallback) . '(' . $result . ')';
            } else {
                $result = Json::encode(array(
                            'state' => 'jsonpCallback参数不合法'
                ));
            }
        }

        return $result;
    }

    /**
     * 记录是否存在
     * @param string $name
     * @return bool
     */
    private function hasConfig($name) {
        return isset($this->config[$name]) ? true : false;
    }

    /**
     * 取得记录
     * @param string $name
     * @return string
     */
    private function getConfig($name) {
        $result = '';
        if ($this->hasConfig($name)) {
            $result = $this->config[$name];
        }
        return $result;
    }

    /**
     * 设置配置
     * @param string $name
     * @param string $value
     */
    private function setConfig($name, $value) {
        $this->config[$name] = $value;
    }

    /**
     * 上传存储路径
     * @return string
     */
    private function getUploadBasePath($url = '') {
        return rtrim(Yii::getAlias($this->uploadBasePath), '\\/') . '/' . $url;
    }

    /**
     * 上传WEB路径
     * @return string
     */
    private function getUploadBaseUrl($url = '') {
        return rtrim(Yii::getAlias($this->uploadBaseUrl), '\\/') . '/' . $url;
    }

    private function getConfigJson() {
        $config = $this->config;
        $filterConfig =$this->filterCallback($config);
        return Json::encode($filterConfig);
    }

    private function filterCallback($data) {
        $out = [];
        foreach ($data as $key => $val) {
            if (is_callable($val)) {
                continue;
            }
            if (is_array($val) || is_object($val)) {
                $out[$key] = $this->filterCallback($val);
                continue;
            }
            $out[$key] = $val;
        }
        return $out;
    }

    private function selector() {
        $_GET['action'] = $this->action;
        $CONFIG = $this->config;

        switch ($this->action) {
            case 'config':
                $result = $this->getConfigJson();
                break;

            /* 上传图片 */
            case 'uploadimage':
            /* 上传涂鸦 */
            case 'uploadscrawl':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':

                $result = $this->actionUpload($CONFIG);

                break;

            /* 列出图片 */
            case 'listimage':
            /* 列出文件 */
            case 'listfile':
                $result = $this->actionList($CONFIG);
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = $this->actionCrawler($CONFIG);
                break;

            default:
                $result = Json::encode(array(
                            'state' => '请求地址出错'
                ));
                break;
        }
        return $result;
    }

    private function loadConfig() {
        $this->config = Json::decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents($this->currentPath . '/config.json')), true);
        $this->action = Yii::$app->getRequest()->get('action', null);
        $this->jsonpCallback = Yii::$app->getRequest()->get('jsonpCallback', null);
    }

    /**
     * 修正路径避免直接修改json config
     */
    private function patchConfig() {
        $uploadBasePath = $this->getUploadBasePath();

//上传文件保存结构
//"imagePathFormat": "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
        foreach ($this->pathFormat as $key => $val) {
            $this->setConfig($key, $val);
        }

        //定制config
        foreach ($this->configPatch as $key => $val) {
            if ($this->hasConfig($key)) {
                $this->setConfig($key, $val);
            }
        }
    }

    /**
     * action_crawler.php
     */
    private function actionCrawler($CONFIG) {
        /* 上传配置 */
        $config = array(
            "pathFormat" => $CONFIG['catcherPathFormat'],
            "maxSize" => $CONFIG['catcherMaxSize'],
            "allowFiles" => $CONFIG['catcherAllowFiles'],
            "oriName" => "remote.png"
        );
        $fieldName = $CONFIG['catcherFieldName'];

        /* 抓取远程图片 */
        $list = array();
        $source = Yii::$app->request->post($fieldName);
        if (!$source) {
            $source = Yii::$app->request->get($fieldName);
        }
        foreach ($source as $imgUrl) {
            //上传基本路径
            $config['uploadBasePath'] = $this->getUploadBasePath();
            $item = new Uploader($imgUrl, $config, "remote");
            $info = $item->getFileInfo();
            array_push($list, array(
                "state" => $info["state"],
                "url" => $this->getUploadBaseUrl($info["url"]),
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ));
        }

        /* 返回抓取数据 */
        return Json::encode(array(
                    'state' => count($list) ? 'SUCCESS' : 'ERROR',
                    'list' => $list
        ));
    }

    private function actionList($CONFIG) {
        /* 判断类型 */
        switch ($this->action) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $CONFIG['fileManagerAllowFiles'];
                $listSize = $CONFIG['fileManagerListSize'];
                $path = $CONFIG['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $CONFIG['imageManagerAllowFiles'];
                $listSize = $CONFIG['imageManagerListSize'];
                $path = $CONFIG['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = Yii::$app->request->get('size', $listSize);
        $size = htmlspecialchars($size);
        $start = Yii::$app->request->get('start', 0);
        $start = htmlspecialchars($start);
        $end = $start + $size;

        /* 获取文件列表 */
        $path = $this->getUploadBasePath() . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
        $files = $this->getfiles($path, $allowFiles);
        if (!count($files)) {
            return Json::encode(array(
                        "state" => "no match file",
                        "list" => array(),
                        "start" => $start,
                        "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

        /* 返回数据 */
        $result = Json::encode(array(
                    "state" => "SUCCESS",
                    "list" => $list,
                    "start" => $start,
                    "total" => count($files)
        ));

        return $result;
    }

    private function actionUpload($CONFIG) {
        try {
            if (is_callable($this->beforeUpload)) {
                call_user_func($this->beforeUpload, $this);
            }
        } catch (\yii\base\Exception $e) {
            return Json::encode(['state' => $e->getMessage()]);
        }

        /* 上传配置 */
        $base64 = "upload";
        switch (htmlspecialchars($this->action)) {
            case 'uploadimage':
                $config = array(
                    "pathFormat" => $CONFIG['imagePathFormat'],
                    "maxSize" => $CONFIG['imageMaxSize'],
                    "allowFiles" => $CONFIG['imageAllowFiles']
                );
                $fieldName = $CONFIG['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathFormat" => $CONFIG['scrawlPathFormat'],
                    "maxSize" => $CONFIG['scrawlMaxSize'],
//                    "allowFiles" => $CONFIG['scrawlAllowFiles'], //bug
                    "oriName" => "scrawl.png"
                );
                $fieldName = $CONFIG['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathFormat" => $CONFIG['videoPathFormat'],
                    "maxSize" => $CONFIG['videoMaxSize'],
                    "allowFiles" => $CONFIG['videoAllowFiles']
                );
                $fieldName = $CONFIG['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathFormat" => $CONFIG['filePathFormat'],
                    "maxSize" => $CONFIG['fileMaxSize'],
                    "allowFiles" => $CONFIG['fileAllowFiles']
                );
                $fieldName = $CONFIG['fileFieldName'];
                break;
        }

        //上传基本路径
        $config['uploadBasePath'] = $this->getUploadBasePath();

        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $base64);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */
        /* 返回数据 */
        $result = $up->getFileInfo();
        if (isset($result['url'])) {
            $result['relativePath'] = $result['url'];
            $result['url'] = $this->getUploadBaseUrl($result['url']);
        }
        //set to public for callback
        $this->result = $result;
        if ($result['state'] == 'SUCCESS') {
            try {
                if (is_callable($this->afterUpload)) {
                    call_user_func($this->afterUpload, $this);
                }
            } catch (\yii\base\Exception $e) {
                return Json::encode(['state' => $e->getMessage()]);
            }
        }
        return Json::encode($result);
    }

    /**
     * 遍历获取目录下的指定类型的文件
     * @param $path
     * @param array $files
     * @return array
     */
    private function getfiles($path, $allowFiles, &$files = array()) {
        if (!is_dir($path))
            return null;
        if (substr($path, strlen($path) - 1) != '/')
            $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    $this->getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                        $files[] = array(
                            'url' => $this->getUploadBaseUrl(substr($path2, strlen($this->getUploadBasePath()))),
                            'mtime' => filemtime($path2)
                        );
                    }
                }
            }
        }
        return $files;
    }

}
