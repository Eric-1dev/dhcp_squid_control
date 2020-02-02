$(function() {
	$('.moveable').draggable({ 
		opacity: 0.5,
		handle:'.header',
		containment: 'parent',
		addClasses: false
		});
});

function load_workspace(value)
{
	$('#waiting').show();
	$('.button').removeClass("selected_page");
	var button_str = "#but_" + value;
	$(button_str).addClass("selected_page");
	document.cookie = "page=" + value + "; expires=31/12/2099";
	$.ajax({
		type: "POST",
		url: value + '.php',
		success: function(result){
			$('#waiting').hide();
			$('#work_space').html(result);
		}
	});
}

function getCookie(name)
{
	var begin = document.cookie.indexOf(name+'=');
	if (-1 == begin)
		return null;
	begin += name.length + 1;
	end = document.cookie.indexOf('; ',begin);
	if (-1 == end)
		end = document.cookie.length;
	return document.cookie.substring(begin,end);
}

function sortGrid(colNum,sortPage)
{
	var tbody = grid.getElementsByTagName('tbody')[0];

	// Составить массив из TR
	var rowsArray = [];
	for(var i = 0; i<tbody.children.length; i++) {
		rowsArray.push(tbody.children[i]);
	}

	// определить функцию сравнения, в зависимости от типа
	var compare;
	compare = function(rowA, rowB)
	{
		if ( rowA.cells[colNum].innerHTML != null )
		{
			var s = rowA.cells[colNum].innerHTML.match(/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/);
			if ( s )
			{
				var anew = ip2long(rowA.cells[colNum].innerHTML);
				var bnew = ip2long(rowB.cells[colNum].innerHTML);
				return anew - bnew;
			}
			else if ( $.isNumeric(rowA.cells[colNum].innerHTML) && $.isNumeric(rowB.cells[colNum].innerHTML) )
			{
				return rowA.cells[colNum].innerHTML - rowB.cells[colNum].innerHTML;
			}
			else
			{
				var anew = rowA.cells[colNum].innerHTML.toLowerCase();
				var bnew = rowB.cells[colNum].innerHTML.toLowerCase();
				return anew > bnew ? 1 : -1;
			}
		}
	};

	// сортировать
	rowsArray.sort( compare );

	// Убрать tbody из большого DOM документа для лучшей производительности
	grid.removeChild(tbody);

	while(tbody.firstChild) {
		tbody.removeChild(tbody.firstChild);
	}

	// добавить результат в нужном порядке в TBODY
	for(var i=0; i<rowsArray.length; i++) {
		tbody.appendChild(rowsArray[i]);
	}

	grid.appendChild(tbody);

	$("table th").removeClass('selected');
	var cn = colNum > 1 ? colNum-1 : colNum // Костыль из-за ячейки с пиктограммами VNC
	var th1 = grid.getElementsByTagName('th')[cn];
	th1.classList.add("selected");

	var sort = colNum | sortPage;
	document.cookie = "sorting_col" + sortPage + "=" + colNum + "; expires=31/12/2099";
}

function ip2long(ip)
{
	var d = ip.split('.');
	return ((((((+d[0])*256)+(+d[1]))*256)+(+d[2]))*256)+(+d[3]);
}

function message(str, type)
{
	switch (type)
	{
		case 'warning':
			$('#message').removeClass("ok");
			$('#message').addClass("warning");
			break;
		case 'ok':
			$('#message').removeClass("warning");
			$('#message').addClass("ok");
			break;
	}
	$('#message').html(str);
	$('#message').animate({ bottom: '20px' }, 400).delay(2000);
	$('#message').animate({ bottom: '-130px' }, 400);
}

function popup_show(value)
{
	switch (value)
	{
		case 'show':
			var cont = $('#popup_container');
			cont.css({
				'left': ($(window).width()-cont.width())/2,
				'top': ($(window).height()-cont.height())/2
			});
			$('#blocker').stop(true, true).fadeTo(400, 0.75);
			$('#popup_container').fadeTo(400, 1);
			break;
		case 'hide':
			$('#blocker').stop(true, true).fadeOut(400);
			$('#popup_container').fadeOut(400);
			break;
	}
}

function dhcp_apply()
{
	$('#waiting').show();
	$.ajax({
		type: "POST",
		url: 'dhcp_apply.php',
		success: function(result){
			$('#waiting').hide();
			message('DHCP-сервер перезапущен с новыми настройками',"ok");
		}
	});
}

function vnc(ip)
{
	if (confirm("Подключиться к " + ip)) {
		window.location.href='cuvnc://' + ip;
	}
}

function clipboardCopy (elem)
{
	var range = document.createRange();
	range.selectNode(elem);
	window.getSelection().addRange(range);
	document.execCommand('copy');
	window.getSelection().removeAllRanges();
	$(elem).fadeOut().fadeIn();
}