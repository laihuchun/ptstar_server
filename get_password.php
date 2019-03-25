<?php
include "wechat_base.php";
include "db_base.php";
include "decrypt_base.php";
$url = urlencode("https://www.sdkjsc.com/ptstar/get_password.php?openid=1"); 
if($_GET['openid'])
{
	$openid = get_access_token($_GET['code']);
	$value =  encrypt($openid);
	//tag is openid ,为了防止别人知道cookies的含义
	setcookie(tag, $value,time()+36000,'/',"www.sdkjsc.com");
}
elseif($_COOKIE["tag"])
{
   $openid = decrypt($_COOKIE["tag"]);	
}
else  
{
web_get_code($url);
}

$find_sql = "select * from user where wechat_no='$openid';";
$row = get_select($find_sql); 
if($row)
{
	$pwd = randpwd();
	$update_sql = "update user set pwd='$pwd' where wechat_no='$openid';";
	update($update_sql);
	echo "<script>alert('$pwd')</script>";
	$ab = $_COOKIE["tag"];
}

else 
{
echo "您不是会员";
}



function randpwd()
{
$len = 6;
$format = 'NUMBER';
 switch($format) { 
 case 'ALL':
 $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; break;
 case 'CHAR':
 $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~'; break;
 case 'NUMBER':
 $chars='0123456789'; break;
 default :
 $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; 
 break;
 }
 mt_srand((double)microtime()*1000000*getmypid()); 
 $password="";
 while(strlen($password)<$len)
    $password.=substr($chars,(mt_rand()%strlen($chars)),1);
 return $password;

}


?>
