<?php
use common\widgets\Menu;
use wanhunet\wanhunet;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            // [
            //     'label' => Yii::t('app', 'Dashboard'),
            //     'url' =>  ['/gii'],
            //     'icon' => 'fa-dashboard',
            //     'active' => Yii::$app->request->url === Yii::$app->homeUrl
            // ],
        	[
                'label' => Yii::t('app', '系统设置'),
                'url' => ['/setting/index'],
                'icon' => 'fa fa-cog',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl,
                'visible' => \Yii::$app->user->can('setting/index'),
            ],
            [
                'label' => Yii::t('app', '内容管理系统'),
                'url' => ['#'],
                'icon' => 'fa-windows',
                'options' => [
                    'class' => 'treeview',
                ],
                'items' => [
                    [
                        'label' => Yii::t('app', '分类管理'),
                        'url' => ['/term/index'],
                        'icon' => 'fa-sitemap',
                        'visible' => \Yii::$app->user->can('term/index'),
                    ],
                    [
                        'label' => Yii::t('app', '文章管理'),
                        'url' => ['/article/index'],
                        'icon' => 'fa fa-pencil-square',
                        'visible' => \Yii::$app->user->can('article/index'),
                    ],
                    [
                        'label' => Yii::t('app', '用户项目管理'),
                        'url' => ['/product/index'],
                        'icon' => 'fa-retweet',
                        'visible' => \Yii::$app->user->can('product/index'),
                    ],
                    [
                        'label' => Yii::t('app', '公司项目管理'),
                        'url' => ['/yyzc/index'],
                        'icon' => 'fa-laptop',
                        'visible' => \Yii::$app->user->can('yyzc/index'),
                    ],
                    [
                        'label' => Yii::t('app', '会员管理'),
                        'url' => ['/member/index'],
                        'icon' => 'fa fa-user',
                        'visible' => \Yii::$app->user->can('member/index'),
                    ],
                    [
                        'label' => Yii::t('app', '轮动广告'),
                        'url' => ['/slider/index'],
                        'icon' => 'fa-th-large',
                        'visible' => \Yii::$app->user->can('slider/index'),
                    ],
					[
                        'label' => Yii::t('app', '模板消息管理'),
                        'url' => ['/mubannews/index'],
                        'icon' => 'fa-sitemap',
                        'visible' => \Yii::$app->user->can('mubannews/index'),
                    ],
					/*  [
                        'label' => Yii::t('app', '新闻动态'),
                        'url' => ['/article/index'],
                        'icon' => 'fa-group',
                    ], */
                    [
                        'label' => Yii::t('app', '支付管理'),
                        'url' => ['/order/index'],
                        'icon' => 'fa fa-pencil-square',
                        'visible' => \Yii::$app->user->can('order/index'),
                    ],
                    [
                        'label' => Yii::t('app', '订单管理'),
                        'url' => ['/invoice/index'],
                        'icon' => 'fa fa-suitcase',
                        'visible' => \Yii::$app->user->can('invoice/index'),
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', '用户与角色'),
                'url' => ['#'],
                'icon' => 'fa fa-cog',
                'visible' => (\Yii::$app->user->can('user/index') || \Yii::$app->user->can('role/index')),
                'options' => [
                    'class' => 'treeview',
                ],
                'items' => [
                    [
                        'label' => Yii::t('app', 'User'),
                        'url' => ['/user/index'],
                        'icon' => 'fa fa-user',
                        'visible' => \Yii::$app->user->can('user/index'),
                    ],
                    [
                        'label' => Yii::t('app', 'Role'),
                        'url' => ['/role/index'],
                        'icon' => 'fa fa-lock',
                        'visible' => \Yii::$app->user->can('role/index'),
                    ],
                ], 
            ],
             [
                'label' => Yii::t('app', '数据统计'),
                'url' => ['#'],
                'icon' => 'fa fa-coffee',
                'visible' => (\Yii::$app->user->can('caiwu/index') || \Yii::$app->user->can('caiwu/shouzhi') || \Yii::$app->user->can('caiwu/wanchengdu')),
                'options' => [
                    'class' => 'treeview',
                ],
                'items' => [
                    [
                        'label' => Yii::t('app', '产品热度统计'),
                        'url' => ['/caiwu/index'],
                        'icon' => 'fa fa-user',
                        'visible' => \Yii::$app->user->can('caiwu/index'),
                    ],
                    [
                        'label' => Yii::t('app', '产品收支统计'),
                        'url' => ['/caiwu/shouzhi'],
                        'icon' => 'fa fa-ticket',
                        'visible' => \Yii::$app->user->can('caiwu/shouzhi'),
                    ],
                    [
                        'label' => Yii::t('app', '产品完成度统计'),
                        'url' => ['/caiwu/wanchengdu'],
                        'icon' => 'fa-keyboard-o',
                        'visible' => \Yii::$app->user->can('caiwu/wanchengdu'),
                    ],
                ], 
            ],
        ]
    ]
);