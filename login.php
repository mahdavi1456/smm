<?php
ob_start();
include"include/theme-functions.php"; include"include/user-functions.php"; include"include/database.php"; include"include/functions.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo get_option('opt_name'); ?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/select2.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.rtl.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.Bootstrap-PersianDateTimePicker.css">
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/select2.min.js"></script>
	<script type="text/javascript" src="js/jquery.Bootstrap-PersianDateTimePicker.js"></script>
	<script type="text/javascript" src="js/jalaali.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body class="wall">
	<section id="login">
		<div class="container-fluid">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="text-center well well-lg">
					<img src="<?php echo get_option('opt_home'); ?>/images/logo.png" title="طراحی و توسعه وب گراتک" alt="طراحی و توسعه وب گراتک"><br><br>
					<hr>
					<form class="form-horizontal form-simple" method="post" action="" novalidate>
						<fieldset class="form-group position-relative has-icon-left mb-0">
							<label>نام کاربری:</label>
							<input type="text" class="form-control" name="u_username" placeholder="نام کاربری" required>
							<div class="form-control-position">
								<i class="icon-head"></i>
							</div>
						</fieldset>
						<fieldset class="form-group position-relative has-icon-left">
							<label>رمز ورود:</label>
							<input type="password" class="form-control" name="u_password" placeholder="رمز ورود" required>
							<div class="form-control-position">
								<i class="icon-key3"></i>
							</div>
						</fieldset>
						<button name="login" type="submit" class="btn btn-success btn-lg btn-block"><i class="icon-unlock2"></i>ورود</button>
					</form>
					<?php
					if(isset($_POST['login'])){
						$username = $_POST['u_username'];
						$password = $_POST['u_password'];
						$st = check_login($username, $password);
						if($st==1){
							$user_id = get_user_id($username);
							$uid = $user_id[0][0];
							header("location: index.php?login=ok&id=" . $uid);
						}else{ ?>
							<br><div class="alert alert-danger">نام کاربری یا رمز وارد شده صحیح نمی باشد</div>
						<?php
						}
					} ?>
				</div>
			</div>
			<div class="col-md-4">
				
			</div>
		</div>
	</section>

<?php include"footer.php"; ?>