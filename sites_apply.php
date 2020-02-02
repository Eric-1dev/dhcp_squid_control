<?php
include "connect.php";

$fp = fopen("/etc/squid3/acls/blocked_sites.txt","w+");

$result = mysqli_query($sql_link, "SELECT * FROM blocked_sites ORDER BY `site`");
while ($sites = mysqli_fetch_array($result))
{
	fputs($fp, ".".$sites['site']."\n");

}
fclose($fp);

shell_exec("/usr/bin/sudo /usr/sbin/squid3 -k reconfigure");

mysqli_close($sql_link);

?>
