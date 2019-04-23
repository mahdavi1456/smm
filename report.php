<?php include"header.php"; ?>
	<div class="container-fluid">
		<h2>گزارش جامع</h2>
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
			<p style="float: right">گزارش مربوط به همه پرداختی ها</p>
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
						<h4 class="panel-title">جدول گزارش پرداخت ها</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>شخص</th>
							<th>مبلغ</th>
							<th>تاریخ</th>
							<th>توضیحات</th>
							<th>نوع پرداخت</th>
						</tr>
						<?php
						$i = 1;
						$n = 0;
						$k = 0;
						if(isset($_POST['search'])){
							$dt = $_POST['year'] . "/" . $_POST['month'];
							$sql = "select * from payment where pa_price > 0 and pa_date like '%" . $dt . "%' order by pa_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_POST['show-today'])){
							$dt = jdate('Y') . "/" . jdate('m') . "/" . jdate('d');
							$sql = "select * from payment where pa_price > 0 and pa_date like '%" . $dt . "%' order by pa_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_POST['show-all'])){
							$sql = "select * from payment where pa_price > 0 order by pa_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_POST['search']) || isset($_POST['show-all']) || isset($_POST['show-today'])){
							if(count($res)>0){
								foreach($res as $row){
									if($row['pa_type']=="نقد"){ ?>
										<tr style="background: #00e732; color: #fff;">
										<?php } else { ?>
										<tr style="background: #73bbff; color: #fff;">
										<?php
										}
										if($row['pa_type']=="نقد"){
											$n += intval($row['pa_price']);
										}else if($row['pa_type']=="کارت"){
											$k += intval($row['pa_price']);
										}
										
										$p_id = $row['p_id'];
										$name = get_var_query("select p_name from person where p_id = $p_id");
										$family = get_var_query("select p_family from person where p_id = $p_id");
										?>
											<td><?php echo per_number($i); ?></td>
											<td><?php echo $name . " " . $family; ?></td>
											<td><?php echo per_number(number_format($row['pa_price'])); ?> تومان</td>
											<td><?php echo per_number($row['pa_date']); ?></td>
											<td><?php echo per_number($row['pa_details']); ?></td>
											<td><?php echo $row['pa_type']; ?></td>
										</tr>
									<?php
									$i++;
								}
								?>
								<tr style="font-size: 20px;">
									<th>جمع پرداخت نقد: </th>
									<td><?php echo per_number(number_format($n)); ?> تومان</td>
									<th>جمع پرداخت کارتخوان: </th>
									<td><?php echo per_number(number_format($k)); ?> تومان</td>
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