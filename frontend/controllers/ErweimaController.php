<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Accesstoken;
use frontend\models\Jk;
use frontend\models\Ticket;



class ErweimaController extends Controller
{
	
    const APPID = 'wxb61ae4d58c99a3ea';
    const APPSECRET = 'f89fbdb557e5718834419ae4b9f4ddf6';
	

	//获取二维码标签
	public function getTicket()
	{
		$access_token = $this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
		//{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
		$data = [
			'action_name' =>"QR_LIMIT_SCENE",
			'action_info'=> [
					'scene'=> [
							'scene_id'=>'123',
						]
				]
			];
		
		$post = json_encode($data);
		$res = $this->httpPost($url, $post);
		
		$res = json_decode($res, true);
		 if(!empty($res['errcode']) && $res['errcode'] > 0){
            if($this->checkAccessToken()){
				
                return $this->getTicket();
            };
        }
		
		$ticket = urlencode($res['ticket']);
		return $ticket;
	}
	
	//获取二维码链接
	public function getErweimaticket() 
	{
		$ticket = $this->getTicket();
		$url1 = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
		return $url1;
	}
	
	//发送二维码
	public function sendErweima($url, $post)
	{
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'Errno'.curl_errno($ch);
		}
        curl_close($ch);
        return $output;
    }
	
	//兑换二维码
	public function getErweima()
	{
		$url = getErweimaticket();
	}
	
	public function Index()
	{
		
		//获取openid
		// require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
        // $tools = new \JsApiPay();
        // $touser = $tools->GetOpenid();
		
		$data_zhifuchenggong = [
			"touser" => 'o-jZztzSDsqJdA3ks1ngORlKNz-A',
           "template_id" => "fYfJ7lQvj-RF5uvHBshUqXiN7ZiA6DMQV-EA4GIQ8GA",
           "url"=>"http://weixin.qq.com/download",            
           "data"=>[
                   "first"=>[
                       "value"=> urlencode("恭喜你购买成功！"),
                       "color"=> "#173177"
                   ],
                   "orderMoneySum"=>[
                       "value"=>"39.8",
                       "color"=>"#173177"
                   ],
                   "orderProductName"=>[
                       "value"=> urlencode("巧克力"),
                       "color"=>"#173177"
                   ],
                   "Remark"=>[
                       "value"=> urlencode("2014年9月22日"),
                       "color"=>"#173177"
                   ],
           ]
		];
		
		
		
		$data = json_encode($data_zhifuchenggong);
		$res = $this->send_template_message(urldecode($data));
		
		var_dump($res);exit;
		$url2 = "https://mp.weixin.qq.com/cgi-bin/massage/customsend?access_token=$access_token";
		//$postimg = json_encode($img);
		$res2 = $this->sendErweima($url2, $img);
		var_dump($res2);exit;
		$this->httpGet1($url1);
		
	}
	
		//发送模板消息
	
	private function send_template_message($data)
	{
		
		$access_token = $this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
		$res = json_decode($this->httpPost($url, $data));
		 if($res->errcode > 0){
            if($this->checkAccessToken()){
				
                return $this->send_template_message($data);
            };
        }
		return $res;
	}
	
	
	//发送模板消息
	/*
		@$data
		$data['touser']
		$data['first']['value']
		($data['first']['color'])
		$data['orderMoneySum']
		$data['orderProductName']
		$data['Remark']
	*/
	public function sendMobanmes($data)
	{
		
		//获取openid
		// require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
        // $tools = new \JsApiPay();
        // $touser = $tools->GetOpenid();
		
		$data_zhifuchenggong = [
			"touser" => $data['touser'],
           "template_id" => "fYfJ7lQvj-RF5uvHBshUqXiN7ZiA6DMQV-EA4GIQ8GA",
           "url"=> $data['url'],            
           "data"=>[
                   "first"=>[
                       "value"=> urlencode($data['first']['value']),
                       "color"=> empty($data['first']['color'])?"#173177":$data['first']['color']
                   ],
                   "orderMoneySum"=>[
                       "value"=> urlencode($data['orderMoneySum']['value']),
                       "color"=> empty($data['orderMoneySum']['color'])?"#173177":$data['orderMoneySum']['color']
                   ],
                   "orderProductName"=>[
                       "value"=> urlencode($data['orderProductName']['value']),
                       "color"=> empty($data['orderMoneySum']['color'])?"#173177":$data['orderMoneySum']['color']
                   ],
                   "Remark"=>[
                       "value"=> urlencode($data['Remark']['value']),
                       "color"=> empty($data['Remark']['color'])?"#173177":$data['Remark']['color']
                   ],
           ]
		];
		
		
		
		$data = json_encode($data_zhifuchenggong);
		$res = $this->send_template_message(urldecode($data));
		return $res;
		
	}
	
	//发送客服消息
	public function kefumes($data)
	{
		$data_kefuxiaoxi = [
			"touser" => $data['touser'],
			"msgtype"=>"text",
			"text"=>
			[
				 "content"=>urlencode($data['content'])
			]
		];
		$data = json_encode($data_kefuxiaoxi);
		$res = $this->sendKefu(urldecode($data));
		return $res;
		
	}
	
	private function sendKefu($data)
	{
		$access_token = $this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$access_token";
		$res = json_decode($this->httpPost($url, $data));
		 if($res->errcode > 0){
            if($this->checkAccessToken()){
                return $this->sendKefu($data);
            };
        }
		return $res;
		
	}
	
	//新增永久素材
	public function addYjsuicai()
	{
		$access_token = $this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=$$access_token";
		
		
	}
	
	private function httpPost($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket(){
        $ticket = $this->getMysqlJsApiTicket();
        $now = time()-rand(0, 120);
        if(!empty($ticket) && $ticket['expire_time'] > $now){
            return $ticket['jsapi_ticket'];
        }else{
            $ticket = $this->getNewJsApiTicket();
            return $ticket;
        }
    }

    private function getNewJsApiTicket(){
        $accessToken = $this->getAccessToken();
        $url = "http://api.weixin.qq.com/cgi-bin/ticket/getticket?type=1&access_token=$accessToken";
        $res = json_decode($this->httpGet($url));
        if($res->errcode > 0){
            if(checkAccessToken()){
                return getNewJsApiTicket();
            };
        }
        $ticket = $res->ticket;
        if ($ticket) {
            $model = new Ticket();
            $model->expire_time = time() + 7000;
            $model->jsapi_ticket = $ticket;
            $model->add_time = time();
            $model->insert();
            $jk = Jk::find()->where(['api' => 'JsApiTicket'])->one();
            $jk['num'] += 1;
            $jk->save();
            //S("JsApiTicket", $data, 3600);
        }
        return $ticket;
    }

    private function getMysqlJsApiTicket(){
        $data = Ticket::find()->orderby("id desc")->one();
        // S("JsApiTicket", $data, 3600);
        return $data;
    }

    private function checkAccessToken(){
        // $access_token = S("access_token");
        // $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$access_token";
        // $res = json_decode($this->httpGet($url));
        // if($res->errcode <= 0){
        //     return true;
        // }
        $access_token = $this->getMysqlAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token['access_token'];
        $res = json_decode($this->httpGet($url));
        if(empty($res->errcode) || $res->errcode <= 0){
            return true;
        }
        $access_token = $this->getNewAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$access_token";
        $res = json_decode($this->httpGet($url));
        if(empty($res->errcode) || $res->errcode <= 0){
            return true;
        }
        return false;
    }

	
    private function getAccessToken() {
        $access_token = $this->getMysqlAccessToken();
        $now = time() - rand(0, 120);
        if(!empty($access_token) && $access_token['expire_time'] > $now){
            return $access_token['access_token'];
        }else{
            $access_token = $this->getNewAccessToken();
            return $access_token;
        }
    }

    private function getNewAccessToken(){
        $appId = yii::$app->params['APPID'];
        $appSecret = yii::$app->params['APPSECRET'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
        $res = json_decode($this->httpGet($url));
        $access_token = $res->access_token;
        if ($access_token) {
            $model = new Accesstoken();
            $model->expire_time = time() + 7000;
            $model->access_token = $access_token;
            $model->add_time = time();
            $model->insert();
            $jk = Jk::find()->where(['api' => 'AccessToken'])->one();
            $jk['num'] += 1;
            $jk->save();
            //S("AccessToken", $data, 3600);
        }
        return $access_token;
    }

    private function getMysqlAccessToken(){
        $data = Accesstoken::find()->orderby("id desc")->one();
        //S("AccessToken", $data, 3600);
        return $data;
    }

    private function httpGet($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
	
	
	
}