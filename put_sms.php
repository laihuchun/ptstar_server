<?php
include "decrypt_base.php";
include "db_base.php";
function getsms()
{
$strParam = $GLOBALS['HTTP_RAW_POST_DATA'];
$sms_content = json_decode($strParam,true);
$count_json = count($sms_content);
$x = 0;
for ($i = 0; $i < $count_json; $i++)
           {
                  $teleno = decrypt($sms_content[$i]['teleno']);
		  $id = $sms_content[$i]['user_id'];
                  $data_time = $sms_content[$i]['data_time'];
                  $imei = decrypt($sms_content[$i]['imei']);
		  if(count($sms_content[$i]['content'])>0)
		  {
		  $tmp = ($sms_content[$i]['content']);
			for ($j = 0; $j < count($tmp); $j++)
			{
                  	$message = decrypt($tmp[$j]);
		  	$message = str_replace("'","\'",$message);
			$long_message .= $message;
			}
		  	$sql1 = "insert into recive_content(user_id,call_no,content,upload_time,rev_time,imei) ";
		  	$sql1 .="values ('$id','$teleno','$long_message','$data_time',NOW(),'$imei');";
			$tiaoshu = insert_data($sql1);
			$x = $x + $tiaoshu; 
		  }
		  else 
			{
                  	$message = decrypt($sms_content[$i]['content']);
		  	$message = str_replace("'","\'",$message);
		  	$sql = "insert into recive_content(user_id,call_no,content,upload_time,rev_time,imei) ";
		  	$sql .="values ('$id','$teleno','$message','$data_time',NOW(),'$imei');";
			$tiaoshu = insert_data($sql);
			$x = $x + $tiaoshu; 
			}
                }
	
	$jieguo = json_encode(array('upload_sms'=>'success','record_count'=>$x));
	echo $jieguo;
return $x;
}

	function insert_data($yuju)
	{
		  if(insert_into($yuju))
			$y = $y + 1;
		  else
			{
			  echo array('upload_sms'=>'failed');
			  return 0;
			}
		  return $y;
	}

 getsms();
?>
