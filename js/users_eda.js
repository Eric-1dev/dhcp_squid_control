function eda_load(action, id)
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'eda_load.php',
		data: {action: action, id: id},
		success: function(result){
			$('#waiting').hide();
			$('#popup_body').html(result);
			popup_show('show');
		}
	});
}

function eda_write(action, id)
{
	$('#waiting').show();
	var name = document.getElementById('eda_name').value;
	var ip = ip2long(document.getElementById('eda_ip').value);
	var mac = document.getElementById('eda_mac').value;
	var dest = document.getElementById('eda_destination').value;
	var aclvl = document.getElementById('eda_accesslvl').value;
	$.ajax({
		type: "POST",
		url: 'eda_write.php',
		data: {action: action, id: id, name: name, ip: ip, mac: mac, dest: dest, aclvl: aclvl},
		success: function(result){
			$('#waiting').hide();
			eda_on_success(result);
		}
	});
}

function user_add()
{
	document.getElementById('popup_header').innerHTML = "<h1>Добавить</h1>";
	document.getElementById('popup_title').innerHTML = "<h1>Добавление новой записи</h1>";
	eda_load('add', -1);
}

function user_edit(id)
{
	document.getElementById('popup_header').innerHTML = "<h1>Редактировать</h1>";
	document.getElementById('popup_title').innerHTML = "<h1>Сохранить изменения в записи (id = " + id + ") ?</h1>";
	eda_load('edit', id);
}

function user_del(id)
{
	document.getElementById('popup_header').innerHTML = "<h1>Удалить</h1>";
	document.getElementById('popup_title').innerHTML = "<h1>Вы действительно хотите удалить запись (id = " + id + ") ?</h1>";
	eda_load('delete', id);
}

function isIpAddress(element)
{
	element.value = element.value.replace(",", ".");
	var ipRegexp = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
	if ( ipRegexp.test(element.value) )
	{
		element.classList.remove("invalid");
		return true;
	}
	else
	{
		element.classList.add("invalid");
		return false;
	}
}

function isMacAddress(element)
{
	element.value = element.value.replace("-", ":");
	element.value = element.value.toUpperCase();
	var macRegexp = /([0-9a-fA-F]{2}([:-]|$)){6}$|([0-9a-fA-F]{4}([.]|$)){3}/;
	if ( macRegexp.test(element.value) )
	{
		element.classList.remove("invalid");
		return true;
	}
	else
	{
		element.classList.add("invalid");
		return false;
	}
}

function isNaturalNum(element)
{
	var regExp = /^[0-9]+$/;
	if ( regExp.test(element.value) )
	{
		element.classList.remove("invalid");
		return true;
	}
	else
	{
		element.classList.add("invalid");
		return false;
	}
}

function isSelected(element)
{
	if ( element.value )
	{
		element.classList.remove("invalid");
		return true;
	}
	else
	{
		element.classList.add("invalid");
		return false;
	}
}

function ip2mac()
{
	ip = document.getElementById('eda_ip');
	if ( isIpAddress(ip) )
	{
		$('#waiting').show();
		$.ajax({
			type: "POST",
			url: 'ip2mac.php',
			data: {ip: ip.value},
			success: function(result){
				$('#waiting').hide();
				getMac(result);
			}
		});
	}
	else
		message('Некорректный IP-адрес', "warning");
}

function getMac(result)
{
	if ( result )
	{
		document.getElementById('eda_mac').value=result;
		isMacAddress(document.getElementById('eda_mac'));
	}
	else
	{
		document.getElementById('eda_mac').value="";
		message('MAC не найден', "warning");
	}
}

function eda_check_fields()
{
	var flag = 1;
	var name = document.getElementById('eda_name');
	var ip = document.getElementById('eda_ip');
	var mac = document.getElementById('eda_mac');
	var dest = document.getElementById('eda_destination');
	var accesslvl = document.getElementById('eda_accesslvl');
	if ( !isSelected(name) )
		flag = 0;
	if ( !isIpAddress(ip) )
		flag = 0;
	if ( !isMacAddress(mac) )
		flag = 0;
	if ( !isSelected(dest) )
		flag = 0;
	if ( !isSelected(accesslvl) )
		flag = 0;
	
	if ( flag )
		return true;
	else
		return false;
}

function eda_confirm(action, id)
{
	if ( action == 'delete' )
		eda_write(action, id);
	else if ( eda_check_fields() )
		eda_write(action, id);
	else
		message("Поля заполнены неверно", "warning");
}

function eda_on_success(result)
{
	if ( result == 0 )
	{
		message("Выполнено", "ok");
		popup_show('hide');
		setTimeout( function(){
			load_workspace('dhcp_users')
		},500 );
	}
	else if ( result == -1 )
		message("Ошибка записи в базу MySQL", "warning");
	else
	{
		var str = "Дублирование полей: <br>";
		if ( result & 1 )
		{
			str+="[Имя] ";
			document.getElementById('eda_name').classList.add("invalid");
		}
		if ( result & 2 )
		{
			str+="[IP] ";
			document.getElementById('eda_ip').classList.add("invalid");
		}
		if ( result & 4 )
		{
			str+="[MAC-адрес] ";
			document.getElementById('eda_mac').classList.add("invalid");
		}
		message(str, "warning");
	}
}
