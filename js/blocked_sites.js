function sites_del(site)
{
	document.getElementById('popup_header').innerHTML = "<h1>Удаление</h1>";
	document.getElementById('popup_title').innerHTML = "<h1>Удалить сайт <"+ site +"> из списка ?</h1>";
	sites_load('delete', site);
}

function sites_add()
{
	document.getElementById('popup_header').innerHTML = "<h1>Добавление</h1>";
	document.getElementById('popup_title').innerHTML = "<h1>Введите адрес сайта:</h1>";
	sites_load('add', '');
}

function sites_load(action, site)
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'sites_load.php',
		data: {action: action, site: site},
		success: function(result){
			$('#waiting').hide();
			$('#popup_body').html(result);
			popup_show('show');
		}
	});
}

function sites_write(action, site)
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'sites_write.php',
		data: {action: action, site: site},
		success: function(result){
			$('#waiting').hide();
			site_on_success(result);
		}
	});
}

function sites_confirm(action, site)
{
	switch (action)
	{
		case 'delete':
			sites_write('delete', site);
			break;
		case 'add':
			var new_site = document.getElementById('new_site');
			if ( isSelected(new_site) )
				sites_write('add', new_site.value);
			else
				message('Введите адрес сайта','warning');
			break;
	}
	
}

function site_on_success(result)
{
	switch (result)
	{
		case '0':
			message('Выполнено', 'ok');
			popup_show('hide');
			setTimeout( function(){
				load_workspace('blocked_sites')
			},500 );
			break;
		case '-1':
			message("Ошибка записи в базу MySQL", 'warning');
			break;
		case '1':
			message("Сайт уже присутствует в списке", 'warning');
			break;
	}
	
}

function sites_apply()
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'sites_apply.php',
		success: function(result){
			$('#waiting').hide();
			message('SQUID перезапущен с новыми настройками','ok');
		}
	});
}