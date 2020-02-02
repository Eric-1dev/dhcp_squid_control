<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jsfunc.js"></script>
<script src="js/users_eda.js"></script>
<script src="js/dhcp_config.js"></script>
<script src="js/blocked_sites.js"></script>

<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/eda.css">
<link rel="stylesheet" type="text/css" href="css/buttons.css">
<link rel="stylesheet" type="text/css" href="css/tables.css">

<body>
<div id="main_menu">
	<a class="button" onclick="location.href='../index.php'">На главную</a>
	<a class="button" id="but_dhcp_users" onclick="load_workspace('dhcp_users')">Управление пользователями</a>
	<a class="button" id="but_leases" onclick="load_workspace('leases')">Арендованные адреса</a>
	<a class="button" id="but_blocked_sites" onclick="load_workspace('blocked_sites')">Черный список сайтов</a>
	<a class="button" id="but_statistics" onclick="load_workspace('statistics')">Просмотр статистики</a>
	<a class="button" id="but_dhcp_config" onclick="load_workspace('dhcp_config')">Настройка DHCP</a>
</div>

<div id="work_space">
	<script>
		load_workspace(getCookie('page'));
	</script>
</div>

<div id="blocker" style="display: none">
</div>

<div id="popup_container" style="display: none" class="moveable">
	<div id="popup_header" class="header"></div>
	<div id="popup_title"></div>
	<div id="popup_body"></div>
</div>

<div id="message">
</div>


<img src="img/ajax-loader.gif" id="waiting" style="display: none">


</body>
</html>
