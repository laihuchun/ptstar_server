<?php
require 'decrypt_base.php';
require 'db_base.php';

header("Content-type: text/html; charset=utf-8");

function check_user_login( $username, $password ,$imei)
{
	if ( empty( $username ) || empty( $password ) || empty( $imei ) ) 
		return false;
	 else 
	{
	   $match = verify($username,$password,$imei); 
	
	   if($match) return true;
	    else return false;
	}
}



function decrypt_content($encrypt_usr,$encrypt_pwd,$encrypt_imei)
{
	if(decrypt($encrypt_pwd)) 
	{
		$decrypt_usr = decrypt($encrypt_usr);
		$decrypt_pwd = decrypt($encrypt_pwd);
		$decrypt_imei = decrypt($encrypt_imei);
		$yan[usr] = $decrypt_usr;
		$yan[pwd] = $decrypt_pwd;
		$yan[imei] = $decrypt_imei;
		return $yan;
	}
	else
	return false;
}



function verify($username,$password,$imei)
{
	$sql = "select user_id,user_name,status from user where user_name = '$username' and pwd = '$password' and imei = '$imei';";
	$db_result = get_select($sql);
	if($db_result)
		return $db_result;
	else
		return false; 
}

$strParam = $GLOBALS['HTTP_RAW_POST_DATA'];
$sms_content=json_decode($strParam,true);
$aa = (json_decode($strParam,true));

$dd =  decrypt($aa[0]["imei"]);
$bb =  decrypt($aa[0]["username"]);
$cc =  decrypt($aa[0]["password"]);
if(decrypt($aa[0]["imei"]) && decrypt($aa[0]["username"]) && decrypt($aa[0]["password"]))
{
$ee = verify($bb,$cc,$dd);
if($ee)
	{
		$ff = array('login_result'=>'success','user_id'=>$ee[0][0],'user_name'=>$ee[0][1],'status'=>$ee[0][2]);
		echo json_encode($ff);
		return json_encode($ff);
	}
else
	{
		$shibai = array('login_result'=>'failed');
		echo json_encode($shibai);
	}
}
else 
{
$ee = json_encode(array('login_result'=>'failed'));
echo $ee;
}
?>
