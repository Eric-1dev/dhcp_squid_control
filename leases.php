<div id="tbl_menu">
<div style="position: absolute; top: 10px; right: 10px" id="number"></div>
</div>
<?php
$file = file("/var/lib/misc/dnsmasq.leases");
$num=sizeof($file);
echo "<script>document.getElementById('number').innerHTML = 'Всего записей: ".$num."';</script>";
$table = "<table id='grid' class='generic' align='center'><thead><tr class='header'>";
$table.= "<th onclick='sortGrid(0,1)' class='sort'>Окончание срока аренды</th>";
$table.= "<th onclick='sortGrid(1,1)' class='sort'>IP-адрес</th>";
$table.= "<th onclick='sortGrid(2,1)' class='sort'>MAC-адрес</th>";
$table.= "<th onclick='sortGrid(3,1)' class='sort'>Имя</th>";
$table.= "</tr></thead><tbody>";

for ( $i=0; $i<$num; $i++ )
{
	$table.= "<tr class='not_header'>";
	$data = explode(" ",$file[$i]);
//      Читаем окончание срока аренды
	if ( $data[0] )
		$table.= "<td align='center'>".date('d M Y H:m:s',$data[0])."</td>";
	else
		$table.= "<td align='center'>∞</td>";
//      Читаем IP
	$table.= "<td>".$data[2]."</td>";
//      Читаем MAC
	$table.= "<td align='center' style='font-family: monospace;'>".strtoupper($data[1])."</td>";
//      Читаем имя компа
	$table.= "<td>".$data[3]."</td>";
	$table.= "</tr>";
}

$table.= "</tbody></table>";

echo "<div id='users_tbl'>";
echo $table;
echo "</div>";
?>

<script>
sortGrid(getCookie("sorting_col1"));
</script>
