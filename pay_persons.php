<?php include"header.php"; ?>
<div class="container-fluid">
	<h2>حساب اشخاص</h2>
	<hr>
	<form action="" method="post" class="form">
	<?php
	$i_id = "";
	$h_text = "";
	$h_type = "";
	$h_price = "";
	$h_date = "";

	if(isset($_POST['edit-payment-table'])){
		$hid = $_POST['edit-payment-table'];
		$res = get_select_query("select * from hesab where hid = $hid");
		$i_id = $res[0]['i_id'];
		$h_text = $res[0]['h_text'];
		$h_type = eng_number($res[0]['h_type']);
		$h_price = $res[0]['h_price'];
		$h_date = $res[0]['h_date'];
	}
	?>
		<div class="row">
			<div class="col-md-2 col-sm-6">
				<h4>شخص</h4>
				<select name="i_id" class="select2 form-control">
				<?php
				$items = get_select_query("select * from items where i_typee in('حسابدار', 'مدیر', 'اشخاص')");
				foreach($items as $item){ ?>
					<option <?php if($i_id==$item['i_id'])echo "selected"; ?> value="<?php echo $item['i_id']; ?>"><?php echo $item['i_namee']; ?></option>
						<?php } ?>
				</select>
			</div>
			<div class="col-md-3">
				<h4>عنوان حساب</h4>
				<input type="text" name="h_text" value="<?php echo $h_text; ?>" class="form-control">
			</div>
			<div class="col-md-3 col-sm-6">
				<h4>وضعیت</h4>
				<select name="h_type" class="form-control">
					<option <?php if($h_type=="بدهکار")echo "selected"; ?> style="background: red; color: #fff;">بدهکار</option>
					<option <?php if($h_type=="بستانکار")echo "selected"; ?> style="background: #00e732; color: #fff;">بستانکار</option>
				</select>
			</div>
			<div class="col-md-2 col-sm-6">
				<h4>مبلغ به تومان</h4>
				<input name="h_price" class="number form-control" type="text" placeholder="مثلا 500.000" value="<?php echo $h_price; ?>">
			</div>
			<div class="col-md-2 col-sm-6">
				<h4>تاریخ</h4>
                <div class="form-group">
        			<label class="sr-only" for="exampleInput1">تاریخ و زمان</label>
        			<div class="input-group">
        				<div class="input-group-addon" data-mddatetimepicker="true" data-trigger="click" data-targetselector="#exampleInput3" data-mdpersiandatetimepicker="" data-enabletimepicker="false" data-mdformat="yyyy/MM/dd" data-mdpersiandatetimepickershowing="false">
                			<span class="glyphicon glyphicon-calendar"></span>
            			</div>
            			<input value="<?php echo $h_date; ?>" name="h_date" type="text" class="form-control" id="exampleInput3" placeholder="تاریخ" data-englishnumber="true" data-mdpersiandatetimepicker="" data-enabletimepicker="false" data-mdformat="yyyy/MM/dd" data-mdpersiandatetimepickershowing="false">
        			</div>
    			</div>
			</div>
			<div class="col-md-12 text-center margin-top30">
				<?php
				if(isset($_POST['edit-payment-table'])){ ?>
				<button value="<?php echo $_POST['edit-payment-table']; ?>" name="edit-payment" class="btn btn-warning btn-lg">ویرایش اطلاعات</button>
				<?php
				} else { ?>
				<button name="set-payment" class="btn btn-success btn-lg">ثبت اطلاعات</button>
				<?php
				} ?>
			</div>

			<div class="col-md-12">
				<?php
				if(isset($_POST['set-payment'])){
					$i_id = $_POST['i_id'];
					$h_text = $_POST['h_text'];
					$h_type = $_POST['h_type'];
					$h_price = str_replace(',', '', $_POST['h_price']);
					$h_date = eng_number($_POST['h_date']);
					
					ex_query("insert into hesab(i_id, h_text, h_type, h_price, h_date) values($i_id, '$h_text', '$h_type', '$h_price', '$h_date')");
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

				if(isset($_POST['edit-payment'])){
					$hid = $_POST['edit-payment'];
					$i_id = $_POST['i_id'];
					$h_text = $_POST['h_text'];
					$h_type = $_POST['h_type'];
					$h_price = str_replace(',', '', $_POST['h_price']);
					$h_date = eng_number($_POST['h_date']);
			
					ex_query("update hesab set i_id = $i_id, h_text = '$h_text', h_type = '$h_type', h_price = '$h_price', h_date = '$h_date' where hid = $hid");
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

					if(isset($_POST['del-payment'])){
						$hid = $_POST['del-payment'];
						ex_query("delete from hesab where hid = $hid");
						?><br>
						<div class="alert alert-success">مورد با موفقیت حذف شد</div>
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
						<h4 class="panel-title">جدول پرداخت ها</h4>
					</div>
				<table class="table table-striped">
					<tr>
						<th>ردیف</th>
						<th>شخص</th>
						<th>عنوان حساب</th>
						<th>وضعیت</th>
						<th>مبلغ به تومان</th>
						<th>تاریخ</th>
						<th>مدیریت</th>
					</tr>
					<?php
					$bed = 0;
					$bes = 0;
					$i = 1;
					$res = get_select_query("select * from hesab");
					if(count($res)>0){
						foreach($res as $row){
							if($row['h_type']=="بدهکار"){
								$bed += $row['h_price'];
								?>
							<tr style="background: red; color: #fff;">
							<?php } else {
								$bes += $row['h_price'];
								?>
							<tr style="background: #00e732; color: #fff;">
							<?php
							} ?>
							<td><?php echo per_number($i); ?></td>
							<td><?php echo get_item_name($row['i_id']); ?></td>
							<td><?php echo $row['h_text']; ?></td>
							<td><?php echo $row['h_type']; ?></td>
							<td><?php echo per_number(number_format($row['h_price'])); ?></td>
							<td><?php echo per_number($row['h_date']); ?></td>
							<td>
								<form action="" method="post">
									<button onclick="confirm('آیا از حذف این مورد اطمینان دارید؟')" name="del-payment" value="<?php echo $row['hid']; ?>" class="btn btn-danger btn-sm">حذف</button>
									<button name="edit-payment-table" value="<?php echo $row['hid']; ?>" class="btn btn-info btn-sm">ویرایش</button>
								</form>
							</td>
						</tr>
						<?php
						$i++;
					}
				} else { ?>
					<tr>
						<td class="text-center" colspan="7">موردی جهت نمایش موجود نیست</td>
					</tr>
					<?php
					}
					?>
					<tr>
						<th></th>
					</tr>
					<tr style="font-size: 20px">
						<th style="background: red; color: #fff;" class="text-center" colspan="3">
							جمع کل بدهکاری: <?php echo per_number(number_format($bed)); ?>
						</th>
						<th style="background: #00e732; color: #fff;" class="text-center" colspan="3">
							جمع بستانکاری: <?php echo per_number(number_format($bes)); ?>
						</th>
						<?php $t = $bes - $bed; ?>
						<th style="background: <?php if($t<0) echo 'red'; else echo '#00e732'; ?>; color: #fff;" class="text-center">
							تراز: <?php echo per_number(number_format($t)); ?>
						</th>
					</tr>
				</table>

			</div>
		</div>
	</div>
</div>
<?php include"footer.php"; ?>