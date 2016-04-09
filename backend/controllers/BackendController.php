<?php
namespace backend\controllers;

use wanhunet\wanhunet;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use common\models\base\User;
use backend\controllers\WeixinController;

class BackendController extends WeixinController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {   
      //$user =  new User;
        //var_dump(\Yii::$app->user->can(wanhunet::$app->controller->getRoute()));exit;

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'controllers' => ['article'],
                       // 'actions' => ['article/index'],
                        'allow' => \Yii::$app->user->can(wanhunet::$app->controller->getRoute()),
                        //'roles' => [wanhunet::$app->controller->getRoute()],
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    //print_r($action);exit;
                    throw new ForbiddenHttpException("没有权限");
                }
            ],
        ];
    }

}