<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>مستغلات و طرف حساب ها</h2>
		<hr>
		<form method="post" action="" class="form">
			<?php
			$i_namee = "";
			$i_mobile = "";
			$i_address = "";
			$i_typee = "";

			if(isset($_POST['edit-item-table'])){
				$i_id = $_POST['edit-item-table'];
				$res = get_select_query("select * from items where i_id = $i_id");
				$i_namee = $res[0]['i_namee'];
				$i_mobile = $res[0]['i_mobile'];
				$i_address = $res[0]['i_address'];
				$i_typee = $res[0]['i_typee'];
			}
			?>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<h3>نوع</h3>
					<select name="i_typee" class="form-control">
						<option <?php if($i_typee=="مستغلات")echo "selected"; ?> value="مستغلات">مستغلات</option>
						<option <?php if($i_typee=="اشخاص")echo "selected"; ?> value="اشخاص">اشخاص</option>
						<option <?php if($i_typee=="حسابدار")echo "selected"; ?> value="حسابدار">حسابدار</option>
						<option <?php if($i_typee=="مدیر")echo "selected"; ?> value="مدیر">مدیر</option>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>نام</h3>
					<input name="i_namee" class="form-control" type="text" placeholder="نام..." value="<?php echo $i_namee; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>موبایل</h3>
					<input name="i_mobile" class="form-control" type="text" placeholder="09xxxxxxxxx" value="<?php echo $i_mobile; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>آدرس</h3>
					<textarea name="i_address" class="form-control" placeholder="خیابان ...." value="<?php echo $i_address; ?>"><?php echo $i_address; ?></textarea>
				</div>
				<div class="col-md-12 text-center">
					<?php
					if(isset($_POST['edit-item-table'])){ ?>
					<button value="<?php echo $_POST['edit-item-table']; ?>" name="edit-item" class="btn btn-warning btn-lg">ویرایش اطلاعات</button>
					<?php
					} else {
					?>
					<button name="set-item" class="btn btn-success btn-lg">ثبت اطلاعات</button>
					<?php
					} ?>
				</div>
				<div class="col-md-12">
					<?php
					if(isset($_POST['set-item'])){
						$i_namee = $_POST['i_namee'];
						$i_mobile = $_POST['i_mobile'];
						$i_address = $_POST['i_address'];
						$i_typee = $_POST['i_typee'];
						ex_query("insert into items(i_namee, i_mobile, i_address, i_typee) values('$i_namee', '$i_mobile', '$i_address', '$i_typee')");
						?><br>
						<div class="alert alert-success">
							مورد با موفقیت ثبت شد
						</div>
						<script type="text/javascript">
							window.location.reload();
							return;
						</script>
						<?php
					}

					if(isset($_POST['edit-item'])){
						$i_id = $_POST['edit-item'];
						$i_namee = $_POST['i_namee'];
						$i_mobile = $_POST['i_mobile'];
						$i_address = $_POST['i_address'];
						$i_typee = $_POST['i_typee'];
						ex_query("update items set i_namee = '$i_namee', i_mobile = '$i_mobile', i_address = '$i_address', i_typee = '$i_typee' where i_id = $i_id");
						?><br>
						<div class="alert alert-warning">
							مورد با موفقیت ویرایش شد
						</div>
						<script type="text/javascript">
							window.location.reload();
							return;
						</script>
						<?php
					}

					if(isset($_POST['del-item'])){
						$i_id = $_POST['del-item'];
						ex_query("delete from items where i_id = $i_id");
						?><br>
						<div class="alert alert-success">
							مورد با موفقیت حذف شد
						</div>
						<script type="text/javascript">
							window.location.reload();
							return;
						</script>
						<?php
					}

					?>
				</div>
			</div>	
		</form>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4 class="panel-title">جدول مستغلات و طرف حساب ها</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نوع</th>
							<th>نام</th>
							<th>موبایل</th>
							<th>آدرس</th>
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$res = get_select_query("select * from items");
						if(count($res)>0){
							foreach($res as $row){ ?>
							<tr>
								<td><?php echo per_number($i); ?></td>
								<td><?php echo $row['i_typee']; ?></td>
								<td><?php echo $row['i_namee']; ?></td>
								<td><?php echo per_number($row['i_mobile']); ?></td>
								<td><?php echo $row['i_address'] ?></td>
								<td>
									<form action="" method="post">
										<button onclick="confirm('آیا از حذف این مورد اطمینان دارید؟')" name="del-item" value="<?php echo $row['i_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
										<button name="edit-item-table" value="<?php echo $row['i_id']; ?>" class="btn btn-info btn-sm">ویرایش</button>
										<a href="manage-media.php?id=<?php echo $row['i_id']; ?>" class="btn btn-warning">اسناد</a>
									</form>
								</td>
							</tr>
							<?php
							$i++;
							}
						} else { ?>
							<tr><td class="text-center" colspan="6">موردی جهت نمایش موجود نیست</td></tr>
						<?php
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php include"footer.php"; ?>