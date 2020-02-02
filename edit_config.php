<?php

switch ($_POST['field'])
{
	case 'iface':
		$str = "&lt;Интерфейс&gt;";
		break;
	case 'domain':
		$str = "&lt;Домен&gt;";
		break;
	case 'start_pool':
		$str = "&lt;Начало пула&gt;";
		break;
	case 'stop_pool':
		$str = "&lt;Конец пула&gt;";
		break;
	case 'gateway':
		$str = "&lt;Основной шлюз&gt;";
		break;
	case 'dns':
		$str = "&lt;DNS&gt;";
		break;
	case 'ntp':
		$str = "&lt;NTP-сервер&gt;";
		break;
	case 'lease_time':
		$str = "&lt;Срок аренды&gt;";
		break;
}
$out = "<table class='generic'><tr>";

$out.= "<tr><td>Редактирование поля:</td>";
$out.= "<td>";
$out.= $str;
$out.= "</td></tr>";
$out.= "<tr><td>Текущее значение:</td>";
$out.= "<td>".$_POST['cur_value']."</td></tr>";
$out.= "</tr></table>";

$out.= "<br>Введите новое значение<br><br>";
$out.= "<input type='text' onkeyup='isSelected(this)' class='eda_input' id='config_new_value'><br><br>";

$out.= "<div align='right'>";
$out.= "<a class='button' onclick=\"config_confirm('".$_POST['field']."')\" id='confirm_button'>Сохранить</a>";
$out.= "<a class='button' onclick=\"popup_show('hide')\">Отмена</a>";
$out.= "</div>";

echo $out;

?>
