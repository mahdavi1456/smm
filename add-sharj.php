<?php include"header.php"; ?>

	<div class="container-fluid">
		<h2>شارژ اشتراک</h2>
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
					<h3>مبلغ</h3>
					<input name="pa_price" class="form-control" type="text" placeholder="مبلغ...">
				</div>
				<div class="col-md-3 col-sm-6">
					<h3>توضیحات</h3>
					<input name="pa_details" class="form-control" type="text" placeholder="توضیحات...">
				</div>
				<div class="col-md-3">
					<h3>نحوه پرداخت</h3>
					<select name="pa_type" class="form-control">
						<option>نقد</option>
						<option>کارتخوان</option>
					</select>
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
						$pa_price = $_POST['pa_price'];
						$pa_date = jdate('Y/m/d');
						$pa_details = $_POST['pa_details'];
						$pa_type = $_POST['pa_type'];
						ex_query("insert into payment(p_id, pa_price, pa_date, pa_details, pa_type) values($p_id, '$pa_price', '$pa_date', '$pa_details', '$pa_type')");
						?><br>
						<div class="alert alert-success">
							مورد با موفقیت ثبت شد
						</div>
						<script type="text/javascript">
							window.location.reload();
							return;
						</script>
						<?php
					} ?>
				</div>
			</div>	
		</form>
	</div>
<?php include"footer.php"; ?>