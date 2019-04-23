<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>مدیریت بسته ها</h2>
		<hr>
		<form method="post" action="" class="form">
			<?php
			$pk_name = "";
			$pk_hour1 = "";
			$pk_hour2 = "";
			$pk_price = "";
			$pk_time = "";
			$pk_expire = "";
			
			if(isset($_POST['edit-item-table'])){
				$pk_id = $_POST['edit-item-table'];
				$res = get_select_query("select * from package where pk_id = $pk_id");
				$pk_name = $res[0]['pk_name'];
				$pk_hour1 = $res[0]['pk_hour1'];
				$pk_hour2 = $res[0]['pk_hour2'];
				$pk_price = $res[0]['pk_price'];
				$pk_time = $res[0]['pk_time'];
				$pk_expire = $res[0]['pk_expire'];
			}
			?>
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<h3>نام بسته</h3>
					<input name="pk_name" class="form-control" type="text" placeholder="نام بسته..." value="<?php echo $pk_name; ?>">
				</div>
				<div class="col-md-4 col-sm-6">
					<h3>هزینه ساعت اول</h3>
					<input name="pk_hour1" class="form-control" type="text" placeholder="هزینه ساعت اول..." value="<?php echo $pk_hour1; ?>">
				</div>
				<div class="col-md-4 col-sm-6">
					<h3>هزینه ساعت دوم</h3>
					<input name="pk_hour2" class="form-control" type="text" placeholder="هزینه ساعت دوم..." value="<?php echo $pk_hour2; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<h3>قیمت بسته</h3>
					<input name="pk_price" class="form-control" type="text" placeholder="قیمت بسته..." value="<?php echo $pk_price; ?>">
				</div>
				<div class="col-md-4 col-sm-6">
					<h3>میزان ساعت</h3>
					<input name="pk_time" class="form-control" type="text" placeholder="میزان ساعت..." value="<?php echo $pk_time; ?>">
				</div>
				<div class="col-md-4 col-sm-6">
					<h3>مدت اعتبار به روز</h3>
					<input name="pk_expire" class="form-control" type="text" placeholder="مدت اعتبار به روز..." value="<?php echo $pk_expire; ?>">
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
						$pk_name = $_POST['pk_name'];
						$pk_hour1 = $_POST['pk_hour1'];
						$pk_hour2 = $_POST['pk_hour2'];
						$pk_price = $_POST['pk_price'];
						$pk_time = $_POST['pk_time'];
						$pk_expire = $_POST['pk_expire'];

						ex_query("insert into package(pk_name, pk_hour1, pk_hour2, pk_price, pk_time, pk_expire) values('$pk_name', $pk_hour1, $pk_hour2, $pk_price, $pk_time, $pk_expire)");
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
						
						$pk_id = $_POST['edit-item'];
						$pk_name = $_POST['pk_name'];
						$pk_hour1 = $_POST['pk_hour1'];
						$pk_hour2 = $_POST['pk_hour2'];
						$pk_price = $_POST['pk_price'];
						$pk_time = $_POST['pk_time'];
						$pk_expire = $_POST['pk_expire'];


						ex_query("update package set pk_name = '$pk_name', pk_hour1 = $pk_hour1, pk_hour2 = $pk_hour2, pk_price = $pk_price, pk_time = $pk_time, pk_expire = $pk_expire where pk_id = $pk_id");
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
						$pk_id = $_POST['del-item'];
						ex_query("delete from package where pk_id = $pk_id");
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
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام بسته</th>
							<th>هزینه ساعت اول</th>
							<th>هزینه ساعت دوم</th>
							<th>قیمت بسته</th>
							<th>میزان ساعت</th>
							<th>مدت اعتبار به روز</th>
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$res = get_select_query("select * from package");
						if(count($res)>0){
							foreach($res as $row){ ?>
							<tr>
								<td><?php echo per_number($i); ?></td>
								<td><?php echo per_number($row['pk_name']); ?></td>
								<td><?php echo per_number(number_format($row['pk_hour1'])); ?></td>
								<td><?php echo per_number(number_format($row['pk_hour2'])); ?></td>
								<td><?php echo per_number(number_format($row['pk_price'])); ?></td>
								<td><?php echo per_number($row['pk_time']); ?></td>
								<td><?php echo per_number($row['pk_expire']); ?></td>
								<td>
									<form action="" method="post">
										<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-item" value="<?php echo $row['pk_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
										<button name="edit-item-table" value="<?php echo $row['pk_id']; ?>" class="btn btn-info btn-sm">ویرایش</button>
									</form>
								</td>
							</tr>
							<?php
							$i++;
							}
						} else { ?>
							<tr><td class="text-center" colspan="8">موردی جهت نمایش موجود نیست</td></tr>
						<?php
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php include"footer.php"; ?>