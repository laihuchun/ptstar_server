<?php
ini_set('date.timezone','Asia/Shanghai'); 
include "lib/log.php";
include "lib/WxPay.Data.php";
include "lib/db_base.php";

$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
$myfile = fopen("logs/pay.log", "a") or die("Unable to open file!");
fwrite($myfile, $xml);
fclose($myfile);

$postObj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
if (count(libxml_get_errors()) > 0) {
                  $xml = libxml_get_errors();
                }


$openid         = $postObj->openid;
$out_trade_no   = $postObj->out_trade_no;
$result_code    = $postObj->result_code;
$return_code    = $postObj->return_code;
$sign           = $postObj->sign;
$time_end       = $postObj->time_end;
$trade_type     = $postObj->trade_type;
$transaction_id = $postObj->transaction_id;
$total_fee	= $postObj->total_fee;
$sql = "insert into wx_result(openid,out_trade_no,result_code,return_code,sign,time_end,trade_type,transaction_id) ";
$sql .= "values('${openid}','${out_trade_no}','${result_code}','${return_code}',";
$sql .= "'${sign}','${time_end}','${trade_type}','${transaction_id}');";
if($transaction_id)
{
insert_into($sql);
if($result_code == 'SUCCESS')
{
	$update_order = "UPDATE order_pt set status = 1 where order_no = '$out_trade_no';";
	update($update_order);
	$money = "update balance set amount = amount + $total_fee ";
	$money .= "where user_id = (select user_id from user where wechat_no = '$openid')";
	//update($money);
	
}
   
}

?>
