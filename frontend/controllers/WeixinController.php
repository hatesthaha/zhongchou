<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Accesstoken;
use frontend\models\Jk;
use frontend\models\Ticket;



class WeixinController extends Controller
{
   
   
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
           "template_id" => $data['template_id'],
           "url"=> $data['url'],            
           "data"=>[
                   "first"=>[
                       "value"=> urlencode($data['first']['value']),
                       "color"=> empty($data['first']['color'])?"#173177":$data['first']['color']
                   ],
                   $data[1]['key']=>[
                       "value"=> urlencode($data[1]['value']),
                       "color"=> empty($data[1]['color'])?"#173177":$data[1]['color']
                   ],
                   $data[2]['key']=>[
                       "value"=> urlencode($data[2]['value']),
                       "color"=> empty($data[2]['color'])?"#173177":$data[2]['color']
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
	
	public function sendMobanmes1($data)
	{
		
		//获取openid
		// require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
        // $tools = new \JsApiPay();
        // $touser = $tools->GetOpenid();
	$data_zhifuchenggong = [
			"touser" => $data['touser'],
           "template_id" => $data['template_id'],
           "url"=> $data['url'],            
           "data"=>[
                   $data[0]['key']=>[
                       "value"=> urlencode($data[0]['value']),
                       "color"=> empty($data[0]['color'])?"#173177":$data[0]['color']
                   ],
                   $data[1]['key']=>[
                       "value"=> urlencode($data[1]['value']),
                       "color"=> empty($data[1]['color'])?"#173177":$data[1]['color']
                   ],
                   $data[2]['key']=>[
                       "value"=> urlencode($data[2]['value']),
                       "color"=> empty($data[2]['color'])?"#173177":$data[2]['color']
                   ],
                   $data[3]['key']=>[
                       "value"=> urlencode($data[3]['value']),
                       "color"=> empty($data[3]['color'])?"#173177":$data[3]['color']
                   ],
           ]
		];
		
		
		
		$data = json_encode($data_zhifuchenggong);
		$res = $this->send_template_message(urldecode($data));
		return $res;
		
	}
	
	
	
	public function sendMobanmes3($data)
	{
		
		//获取openid
		// require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
        // $tools = new \JsApiPay();
        // $touser = $tools->GetOpenid();
		
		$data_zhifuchenggong = [
			"touser" => $data['touser'],
           "template_id" => $data['template_id'],
           "url"=> $data['url'],            
           "data"=>[
                   "first"=>[
                       "value"=> urlencode($data['first']['value']),
                       "color"=> empty($data['first']['color'])?"#173177":$data['first']['color']
                   ],
                   $data[1]['key']=>[
                       "value"=> urlencode($data[1]['value']),
                       "color"=> empty($data[1]['color'])?"#173177":$data[1]['color']
                   ],
                   $data[2]['key']=>[
                       "value"=> urlencode($data[2]['value']),
                       "color"=> empty($data[2]['color'])?"#173177":$data[2]['color']
                   ],
				    $data[3]['key']=>[
                       "value"=> urlencode($data[3]['value']),
                       "color"=> empty($data[3]['color'])?"#173177":$data[3]['color']
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
	
	public function sendMobanmes4($data)
	{
		
		//获取openid
		// require_once(Yii::getAlias('@vendor') . "/payment/wxpay/lib/WxPay.JsApiPay.php");
        // $tools = new \JsApiPay();
        // $touser = $tools->GetOpenid();
		
		$data_zhifuchenggong = [
			"touser" => $data['touser'],
           "template_id" => $data['template_id'],
           "url"=> $data['url'],            
           "data"=>[
                   "first"=>[
                       "value"=> urlencode($data['first']['value']),
                       "color"=> empty($data['first']['color'])?"#173177":$data['first']['color']
                   ],
                   $data[1]['key']=>[
                       "value"=> urlencode($data[1]['value']),
                       "color"=> empty($data[1]['color'])?"#173177":$data[1]['color']
                   ],
                   $data[2]['key']=>[
                       "value"=> urlencode($data[2]['value']),
                       "color"=> empty($data[2]['color'])?"#173177":$data[2]['color']
                   ],
				    $data[3]['key']=>[
                       "value"=> urlencode($data[3]['value']),
                       "color"=> empty($data[3]['color'])?"#173177":$data[3]['color']
                   ],
				    $data[4]['key']=>[
                       "value"=> urlencode($data[4]['value']),
                       "color"=> empty($data[4]['color'])?"#173177":$data[4]['color']
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
		 if($res->errcode == 40001){
            if($this->checkAccessToken()){
                return $this->sendKefu($data);
            };
        }
		return $res;
		
	}
	
		
	private function httpPost($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT,3);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,3);
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
	
   //public $access_token;

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => yii::$app->params['APPID'],
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage; 
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
        // $data = S("JsApiTicket");
        // if ($data->expire_time < $now) {
        //     $ticket = $this->getMysqlJsApiTicket();
        //     if (!$ticket) {
        //         $ticket = $this->getNewJsApiTicket();
        //     }
        // } else {
        //     $ticket = $data->jsapi_ticket;
        // }
        // return $ticket;
    }

    private function getNewJsApiTicket(){
        $accessToken = $this->getAccessToken();
        $url = "http://api.weixin.qq.com/cgi-bin/ticket/getticket?type=1&access_token=$accessToken";
        $res = json_decode($this->httpGet($url));
        if($res->errcode == 40001){
            if($this->checkAccessToken()){
                return $this->getNewJsApiTicket();
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
        $access_token =$this-> getMysqlAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token->access_token;
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
        $now = time()-rand(0, 120);
        if(!empty($access_token) && $access_token['expire_time'] > $now){
            return $access_token['access_token'];
        }else{
            $access_token = $this->getNewAccessToken();
            return $access_token;
        }
        // $data = S("AccessToken");
        // if ($data->expire_time < $now) {
        //     $access_token = $this->getMysqlAccessToken();
        //     if(!$access_token){
        //         $access_token = $this->getNewAccessToken();
        //     }
        // }else{
        //     $access_token = $data->access_token;
        // }
        // return $access_token;
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
		curl_setopt($ch, CURLOPT_TIMEOUT,3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}