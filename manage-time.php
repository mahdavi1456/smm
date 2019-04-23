<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>مدیریت زمان</h2>
		<hr>
		<form method="post" action="" class="form">

			<div class="row">
				<div class="col-md-12">
					<?php
					if(isset($_POST['edit-item'])){
						$bp_id = $_POST['edit-item'];
						$bp_time = $_POST['bp_time'];
						ex_query("update buy_package set bp_time = $bp_time where bp_id = $bp_id");
						?><br>
						<div class="alert alert-success">
							مورد با موفقیت ویرایش شد
						</div>
						<script type="text/javascript">
							window.location.reload();
							return;
						</script>
						<?php
					}

					if(isset($_POST['edit-expire'])){
						$bp_id = $_POST['edit-expire'];
						$bp_expire = $_POST['bp_expire'];
						echo $bp_expire;
						ex_query("update buy_package set bp_expire = '$bp_expire' where bp_id = $bp_id");
						?><br>
						<div class="alert alert-success">
							مورد با موفقیت ویرایش شد
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
		<?php
		$pid = $_GET['pid'];
		?>
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
						$res = get_select_query("select * from buy_package where p_id = $pid");
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
								<td>
									<form action="" method="post">
										<input name="bp_time" type="text" value="<?php echo $row['bp_time']; ?>">
										<button name="edit-item" value="<?php echo $row['bp_id']; ?>" class="btn btn-info btn-sm">ویرایش</button>
									</form>
								</td>
								<td>
									<form action="" method="post">
										<input name="bp_expire" type="text" value="<?php echo $row['bp_expire']; ?>">
										<button name="edit-expire" value="<?php echo $row['bp_id']; ?>" class="btn btn-info btn-sm">ویرایش</button>
									</form>
								</td>
								<td>	
									<form action="" method="post">
										<button  onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-item" value="<?php echo $row['bp_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
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