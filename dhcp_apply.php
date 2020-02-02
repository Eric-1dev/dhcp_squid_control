<?php
include "connect.php";

$result = mysqli_query($sql_link, "SELECT * FROM config");
$config = mysqli_fetch_array($result);

//	Открываем нужные файлы
$fp_config = fopen("/etc/dnsmasq.conf","w+");
$fp_white = fopen("/etc/squid/acls/white_ip.txt", "w+");
$fp_black = fopen("/etc/squid/acls/black_ip.txt", "w+");
$fp_sites = fopen("/etc/squid/acls/blocked_sites.txt","w+");
$fp_realname = fopen("/var/www/site/lightsquid/realname.cfg", "w+");
//      <********************>

//	Забиваем список сайтов
$result = mysqli_query($sql_link, "SELECT * FROM blocked_sites ORDER BY `site`");
while ($sites = mysqli_fetch_array($result))
{
	fputs($fp_sites, ".".$sites['site']."\n");
}
//	<********************>

//	Забиваем конфиг в файл /etc/dnsmasq.conf
fputs($fp_config, "interface=".$config['iface']."\n");
fputs($fp_config, "dhcp-range=".long2ip(-(4294967295 - ($config['start_pool'] - 1))).",".long2ip(-(4294967295 - ($config['stop_pool'] - 1))).",".$config['lease_time']."h\n");
fputs($fp_config, "dhcp-option=option:netmask,255.255.240.0\n");
fputs($fp_config, "dhcp-option=option:router,".long2ip(-(4294967295 - ($config['gateway'] - 1)))."\n");
fputs($fp_config, "dhcp-option=option:dns-server,".$config['dns']."\n");
fputs($fp_config, "dhcp-option=option:ntp-server,".long2ip(-(4294967295 - ($config['ntp'] - 1)))."\n");
fputs($fp_config, "domain=".$config['domain']."\n\n");
fputs($fp_config, "enable-tftp\n");
fputs($fp_config, "tftp-root=/tftpboot\n");
fputs($fp_config, "dhcp-boot=pxelinux.0,boothost,192.168.1.1\n\n");
//fputs($fp_config, "dhcp-match=ipxe,175\n");
//fputs($fp_config, "dhcp-boot=net:#ipxe,undionly.kpxe\n");
//fputs($fp_config, "dhcp-boot=bootmenu.ipxe\n\n");
//	<**************************************>

//	Забиваем пользователей в файл /etc/dnsmasq.conf
$result = mysqli_query($sql_link, "SELECT * FROM users ORDER BY ip");
while ($users = mysqli_fetch_array($result))
{
	fputs($fp_config, "dhcp-host=");
	fputs($fp_config, $users['mac']);
	fputs($fp_config, ",".long2ip(-(4294967295 - ($users['ip'] - 1))).",infinite\n");
//	********************************>

//      Запихиваем адреса в нужные аксес листы сквида
	switch ($users['accesslvl'])
	{
		case 0:
			fputs($fp_black, long2ip(-(4294967295 - ($users['ip'] - 1)))."\n");
			break;
		case 2:
			fputs($fp_white, long2ip(-(4294967295 - ($users['ip'] - 1)))."\n");
			break;
	}
	fputs($fp_realname, long2ip(-(4294967295 - ($users['ip'] - 1)))." ".$users['name']."\n");
}
//	<********************>

//	Закрываем файлы
fclose($fp_config);
fclose($fp_white);
fclose($fp_black);
fclose($fp_sites);
fclose($fp_realname);
//	<*************>
shell_exec("/usr/bin/sudo /etc/init.d/dnsmasq restart");
shell_exec("/usr/bin/sudo /usr/sbin/squid -k reconfigure");
shell_exec("/usr/bin/sudo /etc/init.d/firewall");

mysqli_close($sql_link);

?>
