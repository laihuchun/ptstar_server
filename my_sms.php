<?php
include "db_base.php";
include "wechat_base.php";
include "decrypt_base.php";
if($_COOKIE["tag"])
{
$openid = decrypt($_COOKIE["tag"]);
}
else
{
$openid = get_access_token($_GET['code']);
setcookie(tag, $value,time()+36000,'/',"www.sdkjsc.com");
}

$sql = "select call_no,content,upload_time from recive_content where user_id = (select user_id from user where wechat_no = '$openid');";

$aa = get_select($sql);
echo "<table border=\"1\" cellpadding=\"10\" class=\"full-width\">";

echo "<tr>";
echo "<td>";
echo "来电号码";
echo "</td>";
echo "<td>";
echo "短信内容";
echo "</td>";
echo "<td>";
echo "接收时间";
echo "</td>";
echo "</tr>";

for ($i=0;$i<sizeof($aa);$i++)
{
echo "<tr>";
echo "<td>";
echo  $aa[$i][0];
echo "</td>";

echo "<td>";
echo  $aa[$i][1];
echo "</td>";


echo "<td>";
echo  $aa[$i][2];
echo "</td>";

echo "</tr>";
}
echo "</table>";
?>
<html>
<body>
<center><h1>我的短信记录</h1></center>
<head><link rel="stylesheet" type="text/css" href="biaoge.css">
</head>
<h1>
<div id="search_fun"></div>
<form name="search_mod" method="post" action="">
搜索: <input type="text" name="content" >  <select id="search_type"><option value="search_content" >内容</option><option value="search_no">号码</option></select>

<input type="button" name="submit" value="提交" onClick="search_submit()">
</form>
</h1>

</body>
</html>
