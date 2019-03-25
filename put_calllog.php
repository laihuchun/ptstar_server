<?php
include "decrypt_base.php";
include "db_base.php";
function getcall_log()
{
$strParam = $GLOBALS['HTTP_RAW_POST_DATA'];
$call_log_content=json_decode($strParam,true);
//var_dump($call_log_content);
$count_json = count($call_log_content);
$j = 0;
for ($i = 0; $i < $count_json; $i++)
           {
                  $id = $call_log_content[$i]['user_id'];
                  $call_no = decrypt($call_log_content[$i]['call_no']);
                  $call_time = $call_log_content[$i]['call_time'];
		  $imei = decrypt($call_log_content[$i]['imei']);
		  $call_type = $call_log_content[$i]['call_type'];

		  $sql = "insert into call_log(user_id,imei,upload_time,call_type,call_no,call_time) ";
		  $sql .= "values ('$id','$imei',NOW(),'$call_type','$call_no','$call_time');";
		  //echo  $sql;
		  if(insert_into($sql))
			$j = $j + 1;
		  else
                        {
                          echo array('upload_call_log'=>'failed');
                          return 0;                                                              
                        }    

                }
		$jieguo = json_encode(array('upload_call_log'=>'success','record_count'=>$count_json));
		echo $jieguo;
return $j;
}

 getcall_log();
?>
