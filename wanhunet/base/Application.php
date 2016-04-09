<?php


namespace wanhunet\base;


/**
 * Class Application
 * @package wanhunet\base
 * @property \wanhunet\base\View $view
 * @property \yii\swiftmailer\Mailer $email
 * @author: wuwenhan <329576084@qq.com>
 * @copyright wanhunet
 * @link http://www.wanhunet.com
 */
abstract class Application extends \yii\base\Application
{

    /**
     * @param string $id
     * @param bool $load
     * @return null|\wanhunet\base\Module
     */
    public function getModule($id, $load = true)
    {
        return parent::getModule($id, $load);
    }


}