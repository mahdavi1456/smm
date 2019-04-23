<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>مدیریت اشخاص</h2>
		<hr>
		<form method="post" action="" class="form">
			<?php
			$p_name = "";
			$p_family = "";
			$p_fname = "";
			$p_code = "";
			$p_phone = "";
			$p_mobile = "";
			$p_address = "";
			$p_sharj = "";
			$p_expire = "";
			$p_pack = "";

			if(isset($_POST['edit-item-table'])){
				$p_id = $_POST['edit-item-table'];
				$res = get_select_query("select * from person where p_id = $p_id");
				$p_name = $res[0]['p_name'];
				$p_family = $res[0]['p_family'];
				$p_fname = $res[0]['p_fname'];
				$p_code = $res[0]['p_code'];
				$p_phone = $res[0]['p_phone'];
				$p_mobile = $res[0]['p_mobile'];
				$p_sharj = $res[0]['p_sharj'];
				$p_expire = $res[0]['p_expire'];
				$p_pack = $res[0]['p_pack'];
			}
			?>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<h3>نام</h3>
					<input name="p_name" class="form-control" type="text" placeholder="نام..." value="<?php echo $p_name; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>نام خانوادگی</h3>
					<input id="myFamily" name="p_family" class="form-control" type="text" placeholder="نام خانوادگی..." value="<?php echo $p_family; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>نام پدر</h3>
					<input name="p_fname" class="form-control" type="text" placeholder="نام پدر..." value="<?php echo $p_fname; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>کد اشتراک</h3>
					<input name="p_code" class="form-control" type="text" placeholder="کد اشتراک..." value="<?php echo $p_code; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<h3>تلفن</h3>
					<input name="p_phone" class="form-control" type="text" placeholder="034xxxxxxxxx" value="<?php echo $p_phone; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>موبایل</h3>
					<input name="p_mobile" class="form-control" type="text" placeholder="09xxxxxxxxx" value="<?php echo $p_mobile; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>شارژ</h3>
					<input name="p_sharj" class="form-control" type="text" placeholder="" value="<?php echo $p_sharj; ?>">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>معتبر تا تاریخ</h3>
					<input name="p_expire" class="form-control" type="text" placeholder="" value="<?php echo $p_expire; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-12">
					<h3>بسته</h3>
					<select name="p_pack" class="form-control">
						<option value="0">آزاد</option>
						<?php
						$items = get_select_query("select * from package");
						foreach($items as $item){
						?>
						<option <?php if($item['pk_id']==$p_pack){ echo "selected"; }?> value="<?php echo $item['pk_id']; ?>"><?php echo $item['pk_name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-9 col-sm-12">
					<h3>آدرس</h3>
					<textarea name="p_address" class="form-control" placeholder="خیابان ...." value="<?php echo $p_address; ?>"><?php echo $p_address; ?></textarea>
				</div>
			</div><br>
			<div class="row">
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
						$p_name = $_POST['p_name'];
						$p_family = $_POST['p_family'];
						$p_fname = $_POST['p_fname'];
						$p_code = $_POST['p_code'];
						$p_phone = $_POST['p_phone'];
						$p_mobile = $_POST['p_mobile'];
						$p_address = $_POST['p_address'];
						$p_sharj = $_POST['p_sharj'];
						$p_expire = $_POST['p_expire'];
						$p_pack = $_POST['p_pack'];
						
						if($p_sharj=="")$p_sharj = 0;
						if($p_expire=="")$p_expire = 0;

						ex_query("insert into person(p_name, p_family, p_fname, p_code, p_phone, p_mobile, p_sharj, p_expire, p_address, p_pack) values('$p_name', '$p_family', '$p_fname', '$p_code', '$p_phone', '$p_mobile', $p_sharj, '$p_expire', '$p_address', $p_pack)");
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
						
						$p_id = $_POST['edit-item'];
						$p_name = $_POST['p_name'];
						$p_family = $_POST['p_family'];
						$p_fname = $_POST['p_fname'];
						$p_code = $_POST['p_code'];
						$p_phone = $_POST['p_phone'];
						$p_mobile = $_POST['p_mobile'];
						$p_address = $_POST['p_address'];
						$p_sharj = $_POST['p_sharj'];
						$p_expire = $_POST['p_expire'];
						$p_pack = $_POST['p_pack'];

						ex_query("update person set p_name = '$p_name', p_family = '$p_family', p_fname = '$p_fname', p_code = '$p_code', p_phone = '$p_phone', p_mobile='$p_mobile', p_sharj = $p_sharj, p_expire = '$p_expire', p_address = '$p_address', p_pack = $p_pack where p_id = $p_id");
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
						$p_id = $_POST['del-item'];
						ex_query("delete from person where p_id = $p_id");
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
						<h4 class="panel-title">جدول اشخاص</h4>
					</div>
					<table id="myTable" class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام</th>
							<th>نام خانوادگی</th>
							<th>نام پدر</th>
							<th>کد اشتراک</th>
							<th>تلفن</th>
							<th>موبایل</th>
							<th>آدرس</th>
							<th>شارژ</th>
							<th>تاریخ اعتبار</th>
							<th>بسته</th>
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$res = get_select_query("select * from person order by p_id desc");
						if(count($res)>0){
							foreach($res as $row){
								$p_pack = $row['p_pack'];
								$pack_name = get_var_query("select pk_name from package where pk_id = $p_pack");
								?>
							<tr>
								<td><?php echo per_number($i); ?></td>
								<td><?php echo $row['p_name']; ?></td>
								<td><?php echo $row['p_family']; ?></td>
								<td><?php echo $row['p_fname']; ?></td>
								<td><?php echo per_number($row['p_code']); ?></td>
								<td><?php echo per_number($row['p_phone']); ?></td>
								<td><?php echo per_number($row['p_mobile']); ?></td>
								<td><?php echo $row['p_address'] ?></td>
								<td><?php echo per_number($row['p_sharj']); ?></td>
								<td><?php echo per_number($row['p_expire']); ?></td>
								<td><?php echo $pack_name; ?></td>
								<td>
									<form action="" method="post">
										<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-item" value="<?php echo $row['p_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
										<button name="edit-item-table" value="<?php echo $row['p_id']; ?>" class="btn btn-info btn-sm">ویرایش</button>
									</form>
								</td>
							</tr>
							<?php
							$i++;
							}
						} else { ?>
							<tr><td class="text-center" colspan="12">موردی جهت نمایش موجود نیست</td></tr>
						<?php
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php include"footer.php"; ?>