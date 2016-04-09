<?php
/**
 * Created by PhpStorm.
 * User: wuwenhan
 * Date: 2015/7/7
 * Time: 9:03
 */


namespace wanhunet\helpers;

use wanhunet\wanhunet;
use backend\models\Auth;
class AdminNav
{
    /** @var string */
    private static $_adminNav = 'adminNav';

    /** @var null|\yii\rbac\ManagerInterface */
    private static $_authManager = null;

    public static function all()
    {
        return wanhunet::getParam(self::$_adminNav);
    }

    public static function userAbleAll()
    {
        return wanhunet::getParam(self::$_adminNav);
    }

    /**
     * @param $userId
     */
    public static function initAdminAuth($userId)
    {
        self::enSureAuthManager();
        /**
         * @param                            $data
         * @param \yii\rbac\ManagerInterface $authManager
         * @param null                       $parent
         */
        function addItem($data, $authManager, $parent = null)
        {
            foreach ($data as $d) {

                $item              = $authManager->createPermission($d['action']);
                $item->description = $d['name'];
                $authManager->add($item);


                $authManager->addChild($parent, $item);

                if (isset($d['children'])) {
                    addItem($d['children'], $authManager, $item);
                }

            }

        }

        wanhunet::app()->db->transaction(function () use ($userId) {
            self::cleanAll();
            $role              = self::$_authManager->createRole('admin');
            $role->description = '超级管理员';
            self::$_authManager->add($role);
            addItem(self::all(), self::$_authManager, $role);

            self::$_authManager->assign($role, $userId);
        });
    }

    public static function view()
    {
        self::enSureAuthManager();

        print_r(self::$_authManager->getPermissionsByUser(2));
    }


    public static function cleanAll()
    {
        self::enSureAuthManager();
        self::$_authManager->removeAll();
    }


    private static function enSureAuthManager()
    {
        if (self::$_authManager === null) {
            self::$_authManager = wanhunet::app()->authManager;
        }
    }
}