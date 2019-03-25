<?php

include "db_base.php";

$type = $_POST['type'];
$condition = $_POST['condition'];
//type 1 根据内容 2 根据手机号码
if($type == 'search_content')
{
	$sql = "select * from recive_content";
	$sql .= " where content like '%$condition%';";
}
elseif($type == 'search_no')
{
	$sql = "select * from recive_content";
	$sql .= " where  call_no like '%$condition%'; ";
}

$con = connect();
$jieguo = get_select($sql);
return $jieguo;

?>
