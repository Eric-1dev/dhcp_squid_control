<?php

if ( !empty($_POST['action']) )
{
	if ( $_POST['action'] == 'delete' )
	{
		$out = "<div align='right'>";
		$out.= "<a class='button' onClick=\"sites_confirm('delete','".$_POST['site']."')\">Удалить</a>";
		$out.= "<a class='button' onclick=\"popup_show('hide')\">Отмена</a></div>";
		echo $out;
	}
	elseif ( $_POST['action'] == 'add' )
	{
		$out = "<input type='text' class='eda_input' id='new_site' onkeyup='isSelected(this)'><br><br>";
		$out.= "<div align='right'><a class='button' onClick=\"sites_confirm('add','')\">Добавить</a>";
		$out.= "<a class='button' onclick=\"popup_show('hide')\">Отмена</a></div>";
		echo $out;
	}
}

?>
