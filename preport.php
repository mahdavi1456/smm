<?php include"header.php"; ?>
	<div class="container-fluid">
		<h2>گزارش بسته ها</h2>
		<hr>
		<form action="" method="post" class="form">
			<div class="row">
				<div class="col-md-12 text-center margin-top30">
					<button name="show-paid" class="btn btn-success btn-lg">نمایش پرداخت شده ها</button>
					<button name="show-unpaid" class="btn btn-danger btn-lg">نمایش پرداخت نشده ها</button>
				</div>
			</div>	
		</form>
		
		<hr>

		<h4 class="col-md-12">
		<?php
		if(isset($_POST['show-paid'])){ ?>
			<p style="float: right">گزارش بست های پرداخت شده</p>
		<?php
		}
		if(isset($_POST['show-unpaid'])){ ?>
			<p style="float: right">گزارش بسته های پرداخت نشده</p>
		<?php
		}
		?>
		</h4>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4 class="panel-title">جدول گزارش پرداخت بسته ها</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام شخص</th>
							<th>نام بسته</th>
							<th>زمان</th>
							<th>تاریخ انقضا</th>
							<th>وضعیت پرداخت</th>
						</tr>
						<?php
						if(isset($_POST['show-paid'])){
							$sql = "select * from buy_package where bp_type = 'پرداخت شده'";
							$res = get_select_query($sql);
						}
						if(isset($_POST['show-unpaid'])){
							$sql = "select * from buy_package where bp_type = 'پرداخت نشده'";
							$res = get_select_query($sql);
						}
						$i = 1;
						if(isset($_POST['show-paid']) || isset($_POST['show-unpaid'])){
							if(count($res)>0){
								foreach($res as $row){
										if($row['bp_type']=="پرداخت شده"){ ?>
										<tr style="background: #00e732; color: #fff;">
										<?php } else { ?>
										<tr style="background: red; color: #fff;">
										<?php
										}
										$p_name = get_name("person", "p_name", "p_id", $row['p_id']);
										$p_family = get_name("person", "p_family", "p_id", $row['p_id']);

										$pk_name = get_name("package", "pk_name", "pk_id", $row['pk_id']);
										?>
											<td><?php echo per_number($i); ?></td>
											<td><?php echo $p_name . " " . $p_family; ?></td>
											<td><?php echo $pk_name; ?></td>
											<td><?php echo per_number($row['bp_time']); ?></td>
											<td><?php echo per_number($row['bp_expire']); ?></td>
											<td><?php echo $row['bp_type']; ?></td>
										</tr>
									<?php
									$i++;
								}
							} else { ?>
								<tr><td class="text-center" colspan="6">موردی جهت نمایش موجود نیست</td></tr>
							<?php
							}
						}
						?>
					</table>
				</div>
			</div>

		</div>
	</div>
<?php include"footer.php"; ?>