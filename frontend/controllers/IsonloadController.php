<?php
namespace frontend\controllers;
use common\models\LoginForm;
use Yii;
use yii\base\InlineAction;
use yii\helpers\Url;
use yii\web\Controller;
use frontend\models\Sort;
use frontend\models\Member;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\SortController;

/**
 * Site controller
 */
class IsonloadController extends SortController
{
	/**
	*检查session里面的phone，member_id 
    *如果存在这些说明登录正常
    *不存在phone：获取openid，检查member表是否包含openid
    *   存在openid，检查phone，
    *       不存在phone，进入注册页绑定，绑定后存数据入session
    *       存在phone，将phone，member_id存入session
    *   不存在openid，将openid存入member表,进入绑定页面，绑定后存数据入session  
    *
    */
	public function beforeAction($action)
	{
        $session = Yii::$app->session;
		if(empty($session['id']) || empty($session['live'])){
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
	        if(strpos($user_agent, 'MicroMessenger') == true){
                $redirect_url = $_SERVER["REQUEST_URI"];
                if(empty($session['openid'])){
                    require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
                    $tools = new \JsApiPay();
                    $session->set('openid', $tools->GetOpenid());
                }
	            $member = Member::find()->where('openid=:openid',[':openid'=>$session['openid']])->one();
                if(empty($member)){
                    Header("Location:".URL::to(['register/register']).'?link='.$redirect_url);
                    exit();
                }else{
					if (!empty($member['phone'])) {
						$session->set('live', $member['phone']);
					}
                    $session->set('id', $member['id']);
                    $lifeTime = 3600*6;  // 保存6小时 
                    session_set_cookie_params($lifeTime); 
                }
	        }else{
	            echo '请到微信客户端查看';
	            exit;
	        }
		}
        return true;
	}

    //检查session里面的phone，member_id 
    /**
    *如果存在这些说明登录正常
    *不存在phone：获取openid，检查member表是否包含openid
    *   存在openid，检查phone，
    *       不存在phone，进入注册页绑定，绑定后存数据入session
    *       存在phone，将phone，member_id存入session
    *   不存在openid，将openid存入member表,进入绑定页面，绑定后存数据入session  
    *
    */

    // public function Getopenid(){
    //     $user_agent = $_SERVER['HTTP_USER_AGENT'];
    //     //if(strpos($user_agent, 'MicroMessenger') == true){
    //         require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
    //         $tools = new \JsApiPay();
    //         $GLOBALS['_openid']= $tools->GetOpenid();
    //         //yii::info('请到微信客户端查看');
    //         //var_dump($_openid);exit;
    //     // }else{
    //     //     yii::info('请到微信客户端查看');
    //     //     exit;
    //     // }
    // }
}
   