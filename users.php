<?php include"header.php"; ?>  
<div class="container-fluid">
	<?php
	if(isset($_POST['new-users'])){
		$namee = $_POST['namee'];
		$family = $_POST['family'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$level = $_POST['level'];
		ex_query("insert into users(namee, family, username, password, level) values('$namee', '$family', '$username', '$password', '$level')");
		alert("success", "کاربر با موفقیت اضافه شد");
	}
	if(isset($_POST['edit-users'])){
		$id = $_GET['id'];
		$namee = $_POST['namee'];
		$family = $_POST['family'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$level = $_POST['level'];
		ex_query("update users set namee='$namee', family='$family', username='$username', password='$password', level='$level' where ID=$id");
		alert("success", "کاربر با موفقیت ویرایش شد");
	}
	if(isset($_POST['remove'])){
		$id = $_POST['remove'];
		ex_query("delete from users where ID=$id");
		alert("warning", "کاربر با موفقیت حذف شد");
	}
	?>
	<div class="box box-info">
		<?php
		$namee = "";
		$family = "";
		$username = "";
		$password = "";
		$level = "";
		if(isset($_GET['action']) && $_GET['action']=="edit"){
			$id = $_GET['id'];
			$update_list = get_select_query("select * from users where ID=$id");
			if(count($update_list)>0){
				$namee = $update_list[0][1];
				$family = $update_list[0][2];
				$username = $update_list[0][3];
				$password = $update_list[0][4];
				$level = $update_list[0][5];
			}
		}
		?>
		<h2>حساب کاربری</h2>
		<hr>
		<form class="form-horizontal" method="post">
			<div class="box-body">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-2 control-label">نام</label>
						<div class="col-sm-10">
							<input name="namee" value="<?php echo $namee; ?>" type="text" class="form-control" placeholder="نام">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">نام خانوادگی</label>		
						<div class="col-sm-10">
							<input name="family" value="<?php echo $family; ?>" type="text" class="form-control" placeholder="نام خانوادگی">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">نام کاربری</label>		
						<div class="col-sm-10">
							<input name="username" value="<?php echo $username; ?>" type="text" class="form-control" placeholder="نام کاربری">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">رمز ورود</label>		
						<div class="col-sm-10">
							<input name="password" value="<?php echo $password; ?>" type="text" class="form-control" placeholder="رمز ورود">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">سطح دسترسی</label>
						<div class="col-sm-10">
							<select name="level" class="form-control">
								<option <?php if($level=="مدیر")echo "selected"; ?>>مدیر</option>
								<option <?php if($level=="مالی")echo "selected"; ?>>مالی</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2"></label>
						<div class="col-ms-10">
							<?php
							if(isset($_GET['action']) && $_GET['action']=="edit"){
							?>

							<button name="edit-users" type="submit" class="btn btn-warning pull-right">ویرایش کاربر</button>
							<?php
							}else{ ?>
							<button name="new-users" type="submit" class="btn btn-info pull-right">ذخیره کاربر</button>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<table class="table">
						<tr>
							<th>نام</th>
							<th>نام خانوادگی</th>
							<th>نام کاربری</th>
							<th>رمز ورود</th>
							<th>سطح دسترسی</th>
							<th>عملیات</th>
						</tr>
						<?php
						$list = get_select_query("select * from users");
						if(count($list)>0){
							foreach($list as $l){ ?>
							<tr>
								<td><?php echo $l['namee']; ?></td>
								<td><?php echo $l['family']; ?></td>
								<td><?php echo $l['username']; ?></td>
								<td><?php echo $l['password']; ?></td>
								<td><?php echo $l['level']; ?></td>
								<td>
									<a class="btn btn-warning btn-sm" href="users.php?action=edit&id=<?php echo $l['ID']; ?>">ویرایش</a>
									<button value="<?php echo $l['ID']; ?>" name="remove" class="btn btn-danger btn-sm">حذف</button>
								</td>
							</tr>
							<?php
							}
						}else{ ?>
							<tr>
								<td colspan="6">بدون کاربر</td>
							</tr>
						<?php
						} ?>
					</table>
				</div>
			</div>
		</form>
	</div>	
</div>
<?php include"footer.php"; ?>