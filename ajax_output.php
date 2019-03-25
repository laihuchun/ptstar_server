<?php
include 'decrypt_base.php';

 $username = $_POST['user_name'];
 $userage = $_POST['user_age'];
 $usersex = $_POST['user_sex'];


$as = encrypt($username);
$bs = encrypt($userage);
$cs = encrypt($usersex);
$ds = $as . '&' . $bs . '&' . $cs;
echo $as;
echo "<br />";
echo "-------------";
echo $bs;
echo "<br />";
echo "-------------";
echo $cs;
?>
