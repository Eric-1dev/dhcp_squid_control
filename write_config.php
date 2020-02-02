<?php
include "connect.php";

if ( mysqli_query($sql_link, "UPDATE config SET `".$_POST['field']."`='".$_POST['value']."' WHERE `id`=0") )
	echo 0;
else
	echo -1;

mysqli_close($sql_link);
?>
