<?php include"header.php"; ?>
	<div class="container-fluid">
		<h2>گزارش فاکتورها</h2>
		<hr>
		<?php
		if(isset($_POST['month'])){
			$month = $_POST['month'];
		}else{
			$month = jdate('m');
		}
		if(isset($_POST['year'])){
			$year = $_POST['year'];
		}else{
			$year = jdate('Y');
		}
		?>
		<form action="" method="post" class="form">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<h4>ماه</h4>
					<select name="month" class="select2 form-control">
						<option <?php if($month=="01")echo "selected"; ?> value="01">فروردین</option>
						<option <?php if($month=="02")echo "selected"; ?> value="02">اردیبهشت</option>
						<option <?php if($month=="03")echo "selected"; ?> value="03">خرداد</option>
						<option <?php if($month=="04")echo "selected"; ?> value="04">تیر</option>
						<option <?php if($month=="05")echo "selected"; ?> value="05">مرداد</option>
						<option <?php if($month=="06")echo "selected"; ?> value="06">شهریور</option>
						<option <?php if($month=="07")echo "selected"; ?> value="07">مهر</option>
						<option <?php if($month=="08")echo "selected"; ?> value="08">آبان</option>
						<option <?php if($month=="09")echo "selected"; ?> value="09">آذر</option>
						<option <?php if($month=="10")echo "selected"; ?> value="10">دی</option>
						<option <?php if($month=="11")echo "selected"; ?> value="11">بهمن</option>
						<option <?php if($month=="12")echo "selected"; ?> value="12">اسفند</option>
					</select>
				</div>
				<div class="col-md-4 col-sm-6">
					<h4>سال</h4>
					<select name="year" class="select2 form-control">
						<?php
						for($i=1380; $i<=1500; $i++){ ?>
						<option <?php if($year==$i)echo "selected"; ?>><?php echo $i; ?></option>
						<?php
						} ?>
					</select>
				</div>
				<div class="col-md-4 text-center margin-top30">
					<button name="search" class="btn btn-success btn-lg">گزارش تاریخ</button>
					<button name="show-all" class="btn btn-primary btn-lg">گزارش همه</button>
					<button name="show-today" class="btn btn-warning btn-lg">گزارش امروز</button>
				</div>
			</div>	
		</form>
		
		<hr>

		<h4 class="col-md-12">
		<?php
		if(isset($_POST['search'])){
			?>
			<p style="float: right">گزارش مربوط به ماه <?php echo per_number($_POST['month']); ?> سال <?php echo per_number($_POST['year']); ?></p>
		<?php
		}
		if(isset($_POST['show-all'])){ ?>
			<p style="float: right">گزارش مربوط به همه فاکتورها</p>
		<?php
		}
		if(isset($_POST['show-today'])){ ?>
			<p style="float: right">گزارش مربوط به امروز</p>
		<?php
		}
		?>
		</h4>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4 class="panel-title">جدول گزارش فاکتورها</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام شخص</th>
							<th>نام کالا</th>
							<th>مبلغ</th>
							<th>تاریخ</th>
							<th>تراز حساب</th>
						</tr>
						<?php
						$i = 1;
						$s = 0;
						if(isset($_POST['search'])){
							$dt = $_POST['year'] . "/" . $_POST['month'];
							$sql = "select * from factor where f_date like '%" . $dt . "%'";
							$res = get_select_query($sql);
						}
						if(isset($_POST['show-today'])){
							$dt = jdate('Y') . "/" . jdate('m') . "/" . jdate('d');
							$sql = "select * from factor where f_date like '%" . $dt . "%'";
							$res = get_select_query($sql);
						}
						if(isset($_POST['show-all'])){
							$sql = "select * from factor";
							$res = get_select_query($sql);
						}
						if(isset($_POST['search']) || isset($_POST['show-all']) || isset($_POST['show-today'])){
							if(count($res)>0){
								foreach($res as $row){ ?>
										<tr>
										<?php
										$pr_id = $row['pr_id'];
										$buy = get_var_query("select pr_buy from product where pr_id = $pr_id");
										$sale = get_var_query("select pr_sale from product where pr_id = $pr_id");
										$s += $sale - $buy;

										$p_name = get_name("person", "p_name", "p_id", $row['p_id']);
										$p_family = get_name("person", "p_family", "p_id", $row['p_id']);
										$pr_name = get_name("product", "pr_name", "pr_id", $row['pr_id']);
										?>
											<td><?php echo per_number($i); ?></td>
											<td><?php echo $p_name . " " . $p_family; ?></td>
											<td><?php echo $pr_name; ?></td>
											<td><?php echo per_number(number_format($row['pr_price'])); ?></td>
											<td><?php echo per_number($row['f_date']); ?></td>
											<td><?php calc_pay_status($row['p_id']); ?></td>
										</tr>
									<?php
									$i++;
								}
								?>
								<tr style="font-size: 20px;">
									<th>سود: </th>
									<td colspan="4"><?php echo per_number(number_format($s)); ?> تومان</td>
								</tr>
							<?php
							} else { ?>
								<tr><td class="text-center" colspan="5">موردی جهت نمایش موجود نیست</td></tr>
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