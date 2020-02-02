function load_config(field, cur_value)
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'edit_config.php',
		data: {field: field, cur_value: cur_value},
		success: function(result){
			$('#waiting').hide();
			$('#popup_body').html(result);
			popup_show('show');
		}
	});
}

function write_config(field, new_value)
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'write_config.php',
		data: {field: field, value: new_value},
		success: function(result){
			$('#waiting').hide();
			config_on_success(result);
		}
	});
}

function edit_field(field, cur_value)
{
	document.getElementById('popup_header').innerHTML = "<h1>Редактирование</h1>";
	document.getElementById('popup_title').innerHTML = "";	
	load_config(field, cur_value);
}

function config_confirm(field)
{
	var new_value = document.getElementById('config_new_value');
	// Тут можно реализовать проверку поля input[text]
	// функциями isIface, isDNS, и т.д.
	// А пока просто проверяем заполнение и вызываем write_config()
	switch (field)
	{
		case 'start_pool':
		case 'stop_pool':
		case 'gateway':
		case 'ntp':
			if ( isIpAddress(new_value) )
				write_config(field, ip2long(new_value.value));
			else
				message('Некорректный IP-адрес',"warning");
			break;
		case 'lease_time':
			if ( isNaturalNum(new_value) )
				write_config(field, new_value.value);
			else
				message('Срок аренды должен быть целым положительным числом',"warning");
			break;
		default:
			if ( isSelected(new_value) )
				write_config(field, new_value.value);
			else
				message('Не заполнено поле',"warning");
	}
}

function config_on_success(result)
{
	switch (result)
	{
		case '0':
			message('Выполнено', "ok");
			popup_show('hide');
			setTimeout( function(){
				load_workspace('dhcp_config')
			},500 );
			break;
		case '-1':
			message('Что-то пошло не так', "warning");
			break;
	}
}
