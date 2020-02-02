<div id='tbl_menu'>
<a class='button' onclick="sites_add()">Добавить</a>
<a class='button' onclick="sites_apply()">Применить</a>
</div><br>
<?php
include "connect.php";

$table = "<table class='generic' align='center' width='600px'>";

$table.="<thead><tr class='header'>";
$table.="<th>Сайт</th>";
$table.="<th> </th>";
$table.="</tr></thead><tbody>";

$result = mysqli_query($sql_link, "SELECT * FROM blocked_sites ORDER BY `site`");
while ( $sites_array = mysqli_fetch_array($result) )
{
	$table.="<tr class='not_header'>";
	$table.="<td>".$sites_array['site']."</td>";
	$table.="<td align='center'><input type='button' onClick=\"sites_del('".$sites_array['site']."')\" value='Delete'></td>";
	$table.="</tr>";
}

$table.="</tbody></table>";

echo "<div id='users_tbl'>";
echo $table;
echo "</div>";

mysqli_close($sql_link);
?>
