<?php

namespace backend\controllers;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;
use backend\models\Setting;
use backend\controllers\BackendController;

class SettingController extends BackendController
{

    public function actionIndex()
    {
        if(Yii::$app->request->isPost)
        {
            /*  $siteRoot = str_replace('\\', '/', realpath(dirname(dirname(dirname(__FILE__))) . '/')) . "/frontend/web/upload/";
            if (!empty($_FILES)) {
                if( $_FILES['Setting']['tmp_name']['img']){
                $tempPath = $_FILES['Setting']['tmp_name']['img'];
                $filesName = uniqid() . '.' . pathinfo($_FILES['Setting']['name']['img'], PATHINFO_EXTENSION);
                $uploadPath = $siteRoot . $filesName;

                move_uploaded_file($tempPath, $uploadPath);
                Setting::updateAll(['value' => $filesName], ['code' => 'img']);
                }
            }  */
            $setting = Yii::$app->request->post('Setting');
            foreach($setting as $key => $value) {
                Setting::updateAll(['value' => $value], ['code' => $key]);
            }
        }

        $settingParent = Setting::find()->where(['parent_id' => 0])->orderBy(['sort_order' => SORT_ASC])->all();
        return $this->render('index', [
            'settingParent' => $settingParent,
        ]);
    }

}
