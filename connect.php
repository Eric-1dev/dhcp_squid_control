<?php
$sql_link = mysqli_connect('localhost','dhcpadmin','password') OR DIE("Не могу создать соединение");
mysqli_select_db($sql_link, 'dhcp') or die(mysql_error());
mysqli_query($sql_link, "set names utf8");
?>
