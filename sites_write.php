<?php
include 'connect.php';

$action = $_POST['action'];
$site = $_POST['site'];

if ( $action == 'delete' )
{
	if ( mysqli_query($sql_link, "DELETE FROM blocked_sites WHERE `site`='$site'") )
		echo 0;
	else
		echo -1;
}
elseif ( $action == 'add' )
{
	$site = preg_replace('#http://|ftp://|ww*\.#','',$_POST['site']);
	$site = preg_replace('#/.*#','',$site);
	if (mysqli_num_rows(mysqli_query($sql_link, "SELECT * FROM blocked_sites WHERE site='$site'")) > 0)
		echo 1;
	elseif ( mysqli_query($sql_link, "INSERT INTO blocked_sites (`site`) VALUES ('$site')") )
		echo 0;
	else
		echo -1;
}

mysqli_close($sql_link);
?>
