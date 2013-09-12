<?php
	include("_php/beaver.php");
	include_once '_php/db.php';
	include_once '_php/authorization_control.php';
	include_once '_php/global_config.php';
	
	
	$cooks = '';
	
	$domain = explode('.', $_SERVER['HTTP_HOST']);
	$domain = '.'.$domain[count($domain) - 2].'.'.$domain[count($domain) - 1];//узнаем корневой домен
	
	define('month', 3600 * 24 * 30);
	define('domain', $domain);
	
//	function cookie($name, $val, $exp = month, $path = '/', $domain = domain) {
//		global $cooks;
//                $cooks .= '$.cookie("' . $name . '", null);'.PHP_EOL;
//		$cooks .= '$.cookie("' . $name . '", "' . $val . '", {expires: ' . $exp . ', path: "' . $path . '", domain: "' . $domain . '"});' . PHP_EOL;
//		
//		$_COOKIE[$name] = $val;
//		if(!headers_sent())
//		{
//			setcookie($name, $value, time() + $exp, $path, $domain);
//		}
//		return;
//	}

if ( !empty($_POST['email']) ) {
	if($db->insert('users',array( 
	'email' => $_POST['email'], 
	'fio' => $_POST['surname'] . ' ' . $_POST['name'], 
	'pass' => $_POST['pass'],
	'telephone' => $_POST['phone']
	)
	)) {
		$q = $db->query('SELECT last_insert_id()');
		_cookie_("auth", 1);
		//_cookie_("auth_email", $res[0]['email']);
		_cookie_("auth_fio", $_POST['surname'] . ' ' . $_POST['name']);
		_cookie_("auth_id", $q[0]['last_insert_id()']);
		_cookie_('auth_sid', _security_hash($q[0]['last_insert_id()'], $_POST['email'], $_POST['pass']));
		//$cooks .= 'window.document.location = "/"';
		
		header('Location: http://okred.ru');
	}
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
			meta_data('META');
		?>
		
		<script type="text/javascript">
			<?php echo $cooks; ?>
		</script>
		
		<script src="<?php echo HOST; ?>/_js/jquery-1.8.3.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery-ui.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery.mousewheel.min.js"></script>
		<script src="<?php echo HOST; ?>/_js/jquery.cookie.js"></script>
	</head>
	<body>
		<?php include('_php/top-menu.php'); ?>
		<center>
			<div class="table-wrapper">
				<table class="table-frame">
					<tbody>
						<tr class="content-holder">
							<td class="m20"><div class="td-margin-20"></div></td>
							<td>
								<form method="post" action="/registr.php?add">
									<div><label>Укажите E-mail *</label><br /><input name="email" type="text"></div>
									<div><label>Имя *</label><br /><input name="name" type="text"></div>
									<div><label>Фамилия</label><br /><input name="surname" type="text"></div>
									<div><label>Пароль *</label><br /><input name="pass" type="password"></div>
									<div><label>Повторите пароль *</label><br /><input name="return_pass" type="password"></div>
									<div><label>Мобильный телефон</label><br /><input name="phone" type="text"></div>
									<input type="submit" value="Регистрация">
								</form>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</center>
		
		<?php include('_php/footer.php'); ?>
	</body>
	</html>	