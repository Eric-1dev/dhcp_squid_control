<?php
include 'connect.php';

if ( !empty($_POST['action']) )
{
	$mac_button = "";
	$value=array("", "", "", "", "");

	// Читаем список расположений
	$result = mysqli_query($sql_link, "SELECT * FROM destinations");
	$dests_num = mysqli_num_rows($result);
	while ( $dests_array = mysqli_fetch_array($result) )
	{
		$dests[0][] = $dests_array['id'];
		$dests[1][] = $dests_array['destination'];
	}

	// Читаем список уровней доступа
	$result = mysqli_query($sql_link, "SELECT * FROM accesslvls");
	$accesslvl_num = mysqli_num_rows($result);
	while ( $accesslvl_array = mysqli_fetch_array($result) )
	{
		$accesslvl[0][] = $accesslvl_array['id'];
        $accesslvl[1][] = $accesslvl_array['accesslvl'];
	}

	switch ($_POST['action'])
	{
		case 'add':
			$button = "Добавить";
			$mac_button = "<tr align='center'><td></td><td><a class='button' onclick='ip2mac()'>Запросить MAC</a></td><td></td><td></td><td></td></tr>";
			break;
		case 'edit':
			$button = "Сохранить";
			$mac_button = "<tr align='center'><td></td><td><a class='button' onclick='ip2mac()'>Запросить MAC</a></td><td></td><td></td><td></td></tr>";
			get_user($_POST['id']);
			break;
		case 'delete':
			$button = "Удалить";
			get_user($_POST['id']);
			echo "<script>document.getElementById('eda_name').readOnly = true;</script>";
			echo "<script>document.getElementById('eda_ip').readOnly = true;</script>";
			echo "<script>document.getElementById('eda_mac').readOnly = true;</script>";
			echo "<script>document.getElementById('eda_destination').disabled = true;</script>";
			echo "<script>document.getElementById('eda_accesslvl').disabled = true;</script>";
			break;
	}

	$out = "<table style='border:0' align='center'><tr align='center'>";
	$out.="<td>Имя</td><td>IP</td><td>MAC</td><td>Расположение</td><td>Уровень доступа</td></tr>";
	$out.="<tr align='center'>";
	$out.="<td><input type='text' size='17' class='eda_input' value='".$value[0]."' onkeyup='isSelected(this)' id='eda_name'></td>";
	$out.="<td><input type='text' size='15' class='eda_input' value='".$value[1]."' onkeyup='isIpAddress(this)' id='eda_ip'></td>";
	$out.="<td><input type='text' size='17' class='eda_input' value='".$value[2]."' onkeyup='isMacAddress(this)' id='eda_mac'></td>";

	// Вывод селекта расположений
	$out.="<td><select class='eda_select' id='eda_destination' onchange='isSelected(this)'>";
	$out.="<option></option>";
	for ( $i=0; $i < $dests_num; $i++ )
	{
		if ( $dests[0][$i] == $value[3] )
			$str = " selected";
		else
			$str = "";
		$out.="<option value='".$dests[0][$i]."'".$str.">".$dests[1][$i]."</option>";
	}
	$out.="</td></select>";

	// Вывод селекта уровней доступа
	$out.="<td><select class='eda_select' id='eda_accesslvl' onchange='isSelected(this)'>";
	$out.="<option></option>";
	for ( $i=0; $i < $accesslvl_num; $i++ )
	{
		if ( $accesslvl[0][$i] == $value[4] )
			$str = " selected";
		else
			$str = "";
		$out.="<option value='".$accesslvl[0][$i]."'".$str.">".$accesslvl[1][$i]."</option>";
	}
	$out.="</select></td>";

	$out.=$mac_button;

	// Вывод кнопок Ок/Отмена
	$out.="</tr><tr>";
	$out.="<td></td><td></td><td></td>";
	$out.="<td align='right'><br><a class='button' onClick=\"eda_confirm('".$_POST['action']."','".$_POST['id']."')\" id='confirm_button'>".$button."</a></td>";
	$out.="<td align='right'><br><a class='button' onclick=\"popup_show('hide')\">Отмена</a></td>";
	$out.="</tr></table>";
	echo $out;
}

function get_user($id)
{
	global $value, $accesslvl, $dests, $sql_link;

	$result = mysqli_query($sql_link, "SELECT * FROM users WHERE `id`=".$id);
	$user = mysqli_fetch_array($result);
	$value[0] = $user[1];
	$value[1] = long2ip(-(4294967295 - ($user[3] - 1)));
	$value[2] = $user[4];
	$value[3] = $user[2];
	$value[4] = $user[5];
}

mysqli_close($sql_link);
?>
