<div id='tbl_menu'>
<a class='button' onclick='dhcp_apply()'>Применить</a>
</div><br>

<?php
include "connect.php";

$result = mysqli_query($sql_link, "SELECT * FROM config");
$config = mysqli_fetch_array($result);

$table = "<table class='generic'>";

$table .= "<tr><td>Интерфейс</td>";
$table .= "<td>".$config[1]."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('iface', '".$config['iface']."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>Домен</td>";
$table .= "<td>".$config[2]."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('domain', '".$config['domain']."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>Начало пула адресов</td>";
$table .= "<td>".long2ip(-(4294967295 - ($config[3] - 1)))."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('start_pool', '".long2ip(-(4294967295 - ($config['start_pool'] - 1)))."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>Конец пула адресов</td>";
$table .= "<td>".long2ip(-(4294967295 - ($config[4] - 1)))."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('stop_pool', '".long2ip(-(4294967295 - ($config['stop_pool'] - 1)))."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>Основной шлюз</td>";
$table .= "<td>".long2ip(-(4294967295 - ($config[5] - 1)))."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('gateway', '".long2ip(-(4294967295 - ($config['gateway'] - 1)))."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>DNS-серверы</td>";
$table .= "<td>".$config[6]."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('dns', '".$config['dns']."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>NTP-сервер</td>";
$table .= "<td>".long2ip(-(4294967295 - ($config[7] - 1)))."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('ntp', '".long2ip(-(4294967295 - ($config['ntp'] - 1)))."')\" value='Edit'></td>";
$table .= "</tr>";

$table .= "<tr><td>Срок аренды (в часах)</td>";
$table .= "<td>".$config[8]."</td>";
$table .= "<td><input type='button' onclick=\"edit_field('lease_time', '".$config['lease_time']."')\" value='Edit'></td>";
$table .= "</tr>";


$table.="</table>";

echo "<div id='users_tbl'>";
echo $table;
echo "</div>";

mysqli_close($sql_link);
?>
