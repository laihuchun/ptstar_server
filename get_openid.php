<?
include "wechat_base.php";

$mode = $_GET["mode"];
//mode orderapi=统一下单

switch ($mode)
{
	case orderapi:
	        $url = "https://www.sdkjsc.com/ptstar/wxpay/pay.php";	
		break;
	case jsapi:
		$url = "https://www.sdkjsc.com/ptstar/wxpay/jsapi.php";	
		break;
	case call_log:
		$url = "https://www.sdkjsc.com/ptstar/my_call_log.php";	
		break;
	case sms:
		$url = "https://www.sdkjsc.com/ptstar/my_sms.php";	
		break;
	case account:
		$url = "https://www.sdkjsc.com/ptstar/my_account.php";	
		break;
default:
	$url = "";	
}
web_get_code($url);

?>
