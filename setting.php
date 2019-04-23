<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>تنظیمات</h2>
		<hr>
		<form method="post" action="" class="form">
			<?php
			if(isset($_POST['save_opt'])){
				foreach($_POST as $key=>$value){
					save_option($key, $value);
				}
				?>
				<div class="alert alert-success">تنظیمات با موفقیت ذخیره شد</div>
				<?php
			}
			?>
			<div class="row">
				<div class="col-md-2"><h3>نام مجموعه</h3></div>
				<div class="col-md-3">
					<input name="opt_name" value="<?php echo get_option('opt_name'); ?>" class="form-control" type="text" placeholder="نام مجموعه...">
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-2"><h3>آدرس سایت</h3></div>
				<div class="col-md-3">
					<input style="direction: ltr;" name="opt_home" value="<?php echo get_option('opt_home'); ?>" class="form-control" type="text" placeholder="نام مجموعه...">
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-2"><h3>نرخ آزاد ورودی</h3></div>
				<div class="col-md-3">
					<input style="direction: ltr;" name="opt_hour1" value="<?php echo get_option('opt_hour1'); ?>" class="form-control" type="text" placeholder="نرخ آزاد ورودی">
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-2"><h3>نرخ آزاد هر ساعت</h3></div>
				<div class="col-md-3">
					<input style="direction: ltr;" name="opt_hour2" value="<?php echo get_option('opt_hour2'); ?>" class="form-control" type="text" placeholder="نرخ آزاد هر ساعت">
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-2"><h3>نام کاربری پنل پیامک</h3></div>
				<div class="col-md-3">
					<input style="direction: ltr;" name="sms_user" value="<?php echo get_option('sms_user'); ?>" class="form-control" type="text" placeholder="نام کاربری پنل پیامک">
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-2"><h3>رمز پنل پیامک</h3></div>
				<div class="col-md-3">
					<input style="direction: ltr;" name="sms_pass" value="<?php echo get_option('sms_pass'); ?>" class="form-control" type="password" placeholder="رمز پنل پیامک">
				</div>
			</div><br>
			<div class="row">
				<div class="col-md-2"><h3>شماره خط ارسال پیامک</h3></div>
				<div class="col-md-3">
					<select name="sms_line" class="form-control">
						<option value="-">-</option>
						<option <?php if(get_option('sms_line')=="+985000125475")echo "selected"; ?> value="+985000125475">5000125475</option>
						<option <?php if(get_option('sms_line')=="+981000152")echo "selected"; ?> value="+981000152">1000152</option>
						<option <?php if(get_option('sms_line')=="+985000189")echo "selected"; ?> value="+985000189">5000189</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<button name="save_opt" class="btn btn-warning btn-lg">ذخیره تنظیمات</button>
				</div>
			</div>	
		</form>
	</div>
<?php include"footer.php"; ?>