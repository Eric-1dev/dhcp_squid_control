<?php
include 'connect.php';

$action = $_POST['action'];
$id = $_POST['id'];

if ( $action != 'delete' )
{
	$name = $_POST['name'];
	$ip = $_POST['ip'];
	$mac = $_POST['mac'];
	$dest = $_POST['dest'];
	$aclvl = $_POST['aclvl'];
	if ( $action == 'add' )
	{
		$uniq = checkUniq($name, $ip, $mac, $id); //в данном случае id = -1
		if ( !$uniq )
			if ( mysqli_query($sql_link, "INSERT INTO users (`name`, `ip`, `mac`, `destination`, `accesslvl`) VALUES ('$name', '$ip', '$mac', '$dest', '$aclvl')") )
				echo 0;
			else
				echo -1;
		else
			echo $uniq;
	}
	else if ( $action == 'edit' )
	{
		$uniq = checkUniq($name, $ip, $mac, $id);
		if ( !$uniq )
			if ( mysqli_query($sql_link, "UPDATE users SET `name`='$name', `ip`='$ip', `mac`='$mac', `destination`='$dest', `accesslvl`='$aclvl' WHERE `id`='$id'") )
				echo 0;
			else
				echo -1;
		else
			echo $uniq;
	}
}
else
{
	if ( mysqli_query($sql_link, "DELETE FROM users WHERE `id`='$id'") )
		echo 0;
	else
		echo -1;
}

function checkUniq($name, $ip, $mac, $id)
{
	global $sql_link;
	$flag = 0;
	if (mysqli_num_rows(mysqli_query($sql_link, "SELECT * FROM users WHERE name='$name' AND id<>'$id'")) > 0)
		$flag|=0b001;
	if (mysqli_num_rows(mysqli_query($sql_link, "SELECT * FROM users WHERE ip='$ip' AND id<>'$id'")) > 0)
		$flag|=0b010;
	if (mysqli_num_rows(mysqli_query($sql_link, "SELECT * FROM users WHERE mac='$mac' AND id<>'$id'")) > 0)
		$flag|=0b100;
	return $flag;
}

mysqli_close($sql_link);
?>
