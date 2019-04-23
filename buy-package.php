<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>فروش بسته</h2>
		<hr>
		<form method="post" action="" class="form">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<h3>نام شخص</h3>
					<select name="p_id" class="select2 form-control">
						<?php
						$items = get_select_query("select * from person");
						foreach($items as $item){
						?>
						<option value="<?php echo $item['p_id']; ?>"><?php echo $item['p_name'] . " " . $item['p_family']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>بسته</h3>
					<select id="pk_id" name="pk_id" class="form-control">
						<option>-</option>
						<?php
						$items = get_select_query("select * from package");
						foreach($items as $item){
						?>
						<option value="<?php echo $item['pk_id']; ?>"><?php echo $item['pk_name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>میزان ساعت</h3>
					<input id="bp_time" readonly name="bp_time" class="form-control" type="text" placeholder="میزان ساعت...">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>مدت اعتبار به روز</h3>
					<input id="bp_expire" readonly name="bp_expire" class="form-control" type="text" placeholder="مدت اعتبار به روز...">
				</div>
			</div>
			<div class="row">
				
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
						$p_id = $_POST['p_id'];
						$pk_id = $_POST['pk_id'];
						$bp_time = $_POST['bp_time'];
						$now = jdate('Y/m/d');
						$bp_expire = add_to_datee($now, $_POST['bp_expire']);
						
						ex_query("insert into buy_package(p_id, pk_id, bp_time, bp_expire, bp_type) values($p_id, $pk_id, $bp_time, '$bp_expire', 'پرداخت نشده')");
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

					if(isset($_POST['del-item'])){
						$bp_id = $_POST['del-item'];
						ex_query("delete from buy_package where bp_id = $bp_id");
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
						<h4 class="panel-title">جدول بسته های خریداری شده</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام شخص</th>
							<th>نام بسته</th>
							<th>میزان ساعت</th>
							<th>تاریخ انقضا</th>
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$res = get_select_query("select * from buy_package");
						if(count($res)>0){
							foreach($res as $row){
								$p_name = get_name("person", "p_name", "p_id", $row['p_id']);
								$p_family = get_name("person", "p_family", "p_id", $row['p_id']);
								$package = get_name("package", "pk_name", "pk_id", $row['pk_id']);
								?>
							<tr>
								<td><?php echo per_number($i); ?></td>
								<td><?php echo $p_name . " " . $p_family; ?></td>
								<td><?php echo $package; ?></td>
								<td><?php echo per_number(number_format($row['bp_time'])); ?></td>
								<td><?php echo per_number($row['bp_expire']); ?></td>
								<td>
									<form action="" method="post">
										<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-item" value="<?php echo $row['bp_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
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