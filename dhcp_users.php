<div id="tbl_menu">
<a class='button' onclick='user_add()'>Добавить</a>
<a class='button' onclick='dhcp_apply()'>Применить</a>
<div style="position: absolute; top: 10px; right: 10px" id="number"></div>
</div>
<?php
include "connect.php";

$result = mysqli_query($sql_link, "SELECT * FROM destinations");
while ( $dests_array = mysqli_fetch_array($result) )
{
	$dests[0][] = $dests_array['id'];
	$dests[1][] = $dests_array['destination'];
}

$result = mysqli_query($sql_link, "SELECT * FROM accesslvls");
while ( $accesslvl_array = mysqli_fetch_array($result) )
{
        $accesslvl[0][] = $accesslvl_array['id'];
        $accesslvl[1][] = $accesslvl_array['accesslvl'];
}

$table = "<table class='generic' id='grid' align='center' width='100%'>";

$table.="<thead><tr class='header'>";
$table.="<th onclick='sortGrid(0,0)' class='sort' colspan='2'>Имя</th>";
$table.="<th onclick='sortGrid(2,0)' class='sort'>IP</th>";
$table.="<th onclick='sortGrid(3,0)' class='sort'>MAC</th>";
$table.="<th onclick='sortGrid(4,0)' class='sort'>Расположение</th>";
$table.="<th onclick='sortGrid(5,0)' class='sort'>Уровень доступа</th>";
$table.="<th> </th>";
$table.="</tr></thead><tbody>";

$result = mysqli_query($sql_link, "SELECT * FROM users");
$num = mysqli_num_rows($result);
echo "<script>document.getElementById('number').innerHTML = 'Всего записей: ".$num."';</script>";
while ( $users = mysqli_fetch_array($result) )
{
	switch ( $users[5] )
	{
		case 0:
			$class = "lvl0";
			break;
		case 2:
			$class = "lvl2";
			break;
		default:
			$class = "";
	}

	$ip_addr = long2ip(-(4294967295 - ($users[3] - 1))); //Вот такой теперь пиздец

	$table.="<tr class='not_header ".$class."'>";
	$table.="<td class='td_name'>
					".$users[1]."
			</td>
			<td class='pictogram'>
					<img src='img/ultravnc.png' style='cursor: pointer;' height='20px;' alt='UltraVNC connection' onClick=\"vnc('".$ip_addr."')\"/>
			</td>";
	$table.="<td class='ipAddr' onclick='clipboardCopy(this)' title='Скопировать IP-адрес в буфер обмена'>".$ip_addr."</td>";
	$table.="<td align='center' style='font-family: monospace;'>".str_replace(':', '-', $users[4])."</td>";
	$table.="<td align='center'>".$dests[1][$users[2]]."</td>";
	$table.="<td align='center'>".$accesslvl[1][$users[5]]."</td>";
	$table.="<td align='center'><input type='button' onclick='user_edit(".$users[0].")' value='Edit'>";
	$table.="<input type='button' onclick='user_del(".$users[0].")' value='Delete'></td>";
	$table.="</tr>";
}

$table.="</tbody></table>";

echo "<div id='users_tbl'>";
echo $table;
echo "</div>";

mysqli_close($sql_link);
?>

<script>
sortGrid(getCookie("sorting_col0"));
</script>
