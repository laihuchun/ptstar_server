<?php
$appid =  'wx67c8081d6cc7eb32';
$secret = '79ed3dfdb2f01180f1a4f94f1dfbca9a';
$mch_id = '1367406702';
$nonce_str = '1add1a30ac87aa2db72f57a2375d8fec';

function getaccess_token()
{
	global $appid,$secret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        //执行并获取HTML文档内容
        $post_data = array(
                "grant_type" => "client_credential",
                "appid" => "$appid",
                "secret" => "$secret"
                );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        //var_dump(data);
        $token = json_decode($data);
        $token = $token->access_token;
        curl_close($ch);
        return $token;
}

function web_get_code($redirect_uri)
{
        //$redirect_uri = 'https%3A%2F%2Fwww.sdkjsc.com%2Fwx%2Fvote.php';
	global $appid,$secret;
        $response_type = 'code';
        $scope = 'snsapi_userinfo';
        $state = 'state';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header("Location:" .$url);
        exit;

}

function get_access_token($code)
{
	global $appid,$secret;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/access_token");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	//执行并获取HTML文档内容
$post_data = array(
                "appid" => "$appid",
                "secret" => "$secret",
                "code" => "$code",
                "grant_type" => "authorization_code"
                );
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$data = curl_exec($ch);
		curl_close($ch);                                                                                                                 
                $result = json_decode($data,true);
                //$unionid1 = $result['unionid'];
                $openid = $result['openid'];  
	return $openid;
}



?>
