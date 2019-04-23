<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>ثبت فاکتور</h2>
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
					<h3>محصول</h3>
					<select name="pr_id" class="select2 form-control">
						<?php
						$items = get_select_query("select * from product");
						foreach($items as $item){
						?>
						<option value="<?php echo $item['pr_id']; ?>"><?php echo $item['pr_name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>تعداد</h3>
					<input name="f_count" class="form-control" type="text" placeholder="تعداد...">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>قیمت</h3>
					<input name="pr_price" class="form-control" type="text" placeholder="قیمت...">
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
						$pr_id = $_POST['pr_id'];
						$f_count = $_POST['f_count'];
						$pr_price = $_POST['pr_price'];
						$f_date = jdate('Y/m/d H:i');
						
						ex_query("insert into factor(p_id, pr_id, f_count, pr_price, f_date) values($p_id, $pr_id, $f_count, $pr_price, '$f_date')");
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
						$f_id = $_POST['del-item'];
						ex_query("delete from factor where f_id = $f_id");
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
						<h4 class="panel-title">جدول فاکتورهای ثبت شده</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام شخص</th>
							<th>نام محصول</th>
							<th>تعداد</th>
							<th>قیمت</th>
							<th>تاریخ</th>
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$res = get_select_query("select * from factor");
						if(count($res)>0){
							foreach($res as $row){
								$p_name = get_name("person", "p_name", "p_id", $row['p_id']);
								$pr_name = get_name("product", "pr_name", "pr_id", $row['pr_id']);
								?>
							<tr>
								<td><?php echo per_number($i); ?></td>
								<td><?php echo $p_name; ?></td>
								<td><?php echo $pr_name; ?></td>
								<td><?php echo per_number($row['f_count']); ?></td>
								<td><?php echo per_number(number_format($row['pr_price'])); ?></td>
								<td><?php echo per_number($row['f_date']); ?></td>
								<td>
									<form action="" method="post">
										<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-item" value="<?php echo $row['f_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
									</form>
								</td>
							</tr>
							<?php
							$i++;
							}
						} else { ?>
							<tr><td class="text-center" colspan="7">موردی جهت نمایش موجود نیست</td></tr>
						<?php
						} ?>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php include"footer.php"; ?>