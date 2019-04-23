<?php include"header.php"; ?>
	<div class="container-fluid">
		<h2>گزارش روزانه</h2>
		<hr>
		<h4 class="col-md-12"></h4>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h4 class="panel-title">جدول گزارش پرداخت ها</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>مبلغ</th>
							<th>تاریخ</th>
							<th>توضیحات</th>
							<th>نوع پرداخت</th>
						</tr>
						<?php
						$i = 1;
						$n = 0;
						$k = 0;
						
						$dt = jdate('Y') . "/" . jdate('m') . "/" . jdate('d');
						$sql = "select * from payment where pa_date like '%" . $dt . "%'";
						$res = get_select_query($sql);
						
					
							if(count($res)>0){
								foreach($res as $row){
									if($row['pa_type']=="نقد"){ ?>
										<tr style="background: #00e732; color: #fff;">
										<?php } else { ?>
										<tr style="background: #73bbff; color: #fff;">
										<?php
										}
										if($row['pa_type']=="نقد"){
											$n += $row['pa_price'];
										}else if($row['pa_type']=="کارتخوان"){
											$k += $row['pa_price'];
										}
										?>
											<td><?php echo per_number($i); ?></td>
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
						
						?>
					</table>
				</div>
			</div>

		</div>
	</div>
<?php include"footer.php"; ?>