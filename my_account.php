<?php
include "db_base.php";
include "wechat_base.php";
if($_COOKIE["tag"])
{
$openid = decrypt($_COOKIE["tag"]);
}
else
{
$openid = get_access_token($_GET['code']);
setcookie(tag, $value,time()+36000,'/',"www.sdkjsc.com");
}
$sql = "select contact_name,contact_no from contact where user_id = (select user_id from user where wechat_no = '$openid');";
$aa = get_select($sql);
//var_dump($aa);
echo "<table border=\"1\" cellpadding=\"10\" class=\"full-width\">";

echo "<tr>";
echo "<td>";
echo "联系人姓名";
echo "</td>";

echo "<td>";
echo "号码";
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


echo "</tr>";
}
echo "</table>";


?>
<html>
<body>
<head><link rel="stylesheet" type="text/css" href="biaoge.css">
</head>
<center><h1>我的账户</h1></center>;

</body>
</html>
