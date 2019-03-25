<?php
# 接受上传的联系人信息
include "decrypt_base.php";
include "db_base.php";
function recive_contact()
{
$strParam = $GLOBALS['HTTP_RAW_POST_DATA'];
$contact_content=json_decode($strParam,true);
//var_dump($contact_content);
$count_json = count($contact_content);
$j = 0;
for ($i = 0; $i < $count_json; $i++)
           {
                  $id = $contact_content[$i]['user_id'];
                  $name = decrypt($contact_content[$i]['name']);
                  $contact_list = decrypt($contact_content[$i]['phoneList']);
		  $imei = decrypt($contact_content[$i]['imei']);
		  $sql = "insert into contact(user_id,contact_name,contact_no,upload_date,imei) values ('$id','$name','$contact_list',NOW(),'$imei');";
		  //echo  $sql;
		  if(insert_into($sql))
			$j = $j + 1;
		  else
                        {
                          echo array('upload_contact'=>'failed');
                          return 0;                                                              
                        }    

                }
		$jieguo = json_encode(array('upload_contact'=>'success','record_count'=>$count_json));
		echo $jieguo;
return $j;
}

 recive_contact();
?>
