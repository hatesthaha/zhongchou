<?php
namespace backend\controllers;
/**
 * Created by PhpStorm.
 * User: wuwenhan
 * Date: 2015/7/6
 * Time: 13:17
 */

use wanhunet\wanhunet;
use Yii;
use yii\web\Controller;
use yii\rbac\DbManager;
use wanhunet\helpers\AdminNav;
use backend\controllers\BackendController;

class InitController extends BackendController
{
    public function actionAuth()
    {
        AdminNav::initAdminAuth(wanhunet::app()->user->getId());
    }
    public function actionAuthView()
    {
        var_dump(Yii::$app->params['adminNav']);

        AdminNav::view();
    }
    public function actionIndex(){
        $auth = wanhunet::$app->getAuthManager();

        // add "createPost" permission
        $createPost = $auth->createPermission('new/ceshi');
        $createPost->description = '测试';
        $auth->add($createPost);
    }
}