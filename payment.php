<?php include"header.php"; ?>
	<div class="container-fluid">
		<?php
			if(isset($_POST['sharj'])){
				$p_id = $_GET['p_id'];
				$p_pack = $_POST['p_pack'];
			
				$last_expire = get_var_query("select p_expire from person where p_id = $p_id");
				$last_sharj = get_var_query("select p_sharj from person where p_id = $p_id");
				
				/*
				if($last_expire==0){
					$now = jdate('Y/m/d');
				}else{
					$now = $last_expire;
				}*/
				$now = jdate('Y/m/d');
				
				ex_query("update person set p_pack = $p_pack where p_id = $p_id");
				
				if(isset($_POST['p_expire']) && $_POST['p_expire']!=""){
					$p_expire = add_to_datee($now, $_POST['p_expire']);
					ex_query("update person set p_expire = '$p_expire' where p_id = $p_id");
				}
				
				if(isset($_POST['p_sharj']) && $_POST['p_sharj']!=""){
					$ps = $_POST['p_sharj'];
					//$a = (float)$last_sharj;
					$b = (float)$ps;
					
					//$p_sharj = $a + $b;
					$p_sharj = (float)$b;
					
					ex_query("update person set p_sharj = $p_sharj where p_id = $p_id");
				}
				
				if(isset($_POST['pa_price']) && $_POST['pa_price']!="" && isset($_POST['pa_type']) && $_POST['pa_type']!=""){
					$pa_date = jdate('Y/m/d H:i');
					$pa_details = $_POST['p_sharj'] . " ساعت شارژ و " . $_POST['p_expire'] . " روز اعتبار";
					$pa_price = $_POST['pa_price'];
					$pa_type = $_POST['pa_type'];
					$pa_status = 1;
					ex_query("insert into payment(p_id, pa_price, pa_date, pa_details, pa_type, pa_status) values($p_id, '$pa_price', '$pa_date', '$pa_details', '$pa_type', $pa_status) ");
				}
				?><br>
				<div class="alert alert-success">
					حساب کاربری شخص مورد نظر با موفقیت شارژ شد
				</div>
				<script type="text/javascript">
					window.location.reload();
					return;
				</script>
				<?php
			}
			?>
			
		<div class="row">
			<div class="col-md-6">
				<h3>گزارش حساب اشخاص</h3>
			</div>
			<?php
			if(isset($_GET['show-all'])){
				$p_id = $_GET['p_id'];
			}else{
				$p_id = 0;
			}
			?>
			<div class="col-md-6 text-left">
				<form action="" method="get">
					<select style="width: 70%; float: right;" name="p_id" class="select2 form-control">
						<option>...شخص را انتخاب کنید</option>
						<?php
						$items = get_select_query("select * from person");
						foreach($items as $item){
						?>
						<option <?php if($item['p_id']==$p_id)echo "selected"; ?> value="<?php echo $item['p_id']; ?>"><?php echo $item['p_name'] . " " . $item['p_family']; ?></option>
						<?php } ?>
					</select>
					<button name="show-all" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-search"></span></button>
				</form>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-3 text-center">
				<?php
				if(isset($_GET['p_id'])){
					$p_id = $_GET['p_id'];
					$t = get_person_status($p_id);
					if($t>=0){
						echo "<div style='width: 100%' class='alert alert-success' style='float: left;'><h4 style='margin: 0'>تراز حساب: " . per_number(number_format($t)) . "</h4></div>";
					}else{
						echo "<div style='width: 100%' class='alert alert-danger' style='float: left;'><h4 style='margin: 0'>تراز حساب: " . per_number(number_format($t)) . "</h4></div>";
					}
				}
				?>
			</div>
			
			<div class="col-md-3 text-center">
				<button data-toggle="modal" data-target="#frmSharj" class="btn btn-warning btn-lg" style="width: 100%">
					<span class="glyphicon glyphicon-star"></span>
					شارژ اشتراک
				</button>
			</div>
			
            <div id="frmSharj" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">شارژ اشتراک</h4>
                        </div>
                        <div class="modal-body text-center">
							<form action="" method="post">
								<div class="row">
									<?php
									if(isset($_GET['p_id'])){
										$p_id = $_GET['p_id'];
										$sharj = get_var_query("select p_sharj from person where p_id = $p_id");
										$expire = get_var_query("select p_expire from person where p_id = $p_id");
										$pack = get_var_query("select p_pack from person where p_id = $p_id");
										if($pack==0)
											$pack_name = "آزاد";
										else
											$pack_name = get_var_query("select pk_name from package where pk_id = $pack");
										?>
									<div class="col-md-3">
										<div class="alert alert-warning"><h4 style="margin: 0">شارژ: <?php echo per_number(convert_time($sharj)); ?></h4></div>
									</div>
									<div class="col-md-5">
										<div class="alert alert-warning"><h4 style="margin: 0">اعتبار: <?php echo per_number($expire); ?></h4></div>
									</div>
									<div class="col-md-4">
										<div class="alert alert-warning">
											<h4 style="margin: 0">
											<?php echo per_number($pack_name); ?>
											<select name="p_pack" id="pk_id" class="form-control">
												<?php
												$res = get_select_query("select * from package");
												if(count($res)){
													foreach($res as $row){
													?>
													<option <?php if($row['pk_id']==$pack){ echo "selected"; } ?> value="<?php echo $row['pk_id']; ?>"><?php echo $row['pk_name']; ?></option>
													<?php
													}												
												}
												?>
											</select>
											</h4>
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-md-3">
										<input id="bp_time" name="p_sharj" type="text" class="form-control" placeholder="میزان ساعت">
									</div>
									<div class="col-md-3">
										<input id="bp_expire" name="p_expire" type="text" class="form-control" placeholder="مدت اعتبار">
									</div>
									<div class="col-md-3">
										<input id="bp_price" name="pa_price" type="text" class="form-control" placeholder="مبلغ">
									</div>
									<div class="col-md-3">
										<select class="form-control" name="pa_type">
											<option selected value="کارت">کارت</option>
											<option value="نقد">نقد</option>
										</select>
									</div>
									<input type="hidden" name="p_id" value="<?php echo $_POST['p_id']; ?>">
								</div>
								<br>
								<div class="row">
									<div class="col-md-12">
										<button name="sharj" class="btn btn-success btn-lg">
											<span class="glyphicon glyphicon-ok"></span> شارژ اشتراک
										</button>
									</div>
									<?php
									} ?>
								</div>
							</form>
                        </div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
						</div>
                    </div>
                </div>
            </div>
			
			<div class="col-md-3 text-center">
				<?php
				if(isset($_GET['p_id'])){
					$p_id = $_GET['p_id'];
					$t = get_person_status($p_id);
					echo "<div class='alert alert-warning'>شارژ " . per_number(convert_time($sharj)) . " ساعت تا " . per_number($expire) . "</div>";
				}
				?>
			</div>
				
			<div class="col-md-3 text-center">
				<a href="person.php"><button class="btn btn-info btn-lg" style="width: 100%">
					<span class="glyphicon glyphicon-user"></span>
					ویرایش اطلاعات
				</button>
				</a>
			</div>
		</div>
		<?php
		if(isset($_POST['p_id'])){
			$iitem = $_POST['p_id'];
		}else{
			$iitem = "";
		}
		if(isset($_POST['month'])){
			$month = $_POST['month'];
		}else{
			$month = "";
		}
		if(isset($_POST['year'])){
			$year = $_POST['year'];
		}else{
			$year = "";
		}

		if(isset($_POST['set-package-pay'])){
			$bp_id = $_POST['bp_id'];
			ex_query("update buy_package set bp_type = 'پرداخت شده' where bp_id = $bp_id");
			$pk_id = $_POST['pk_id'];
			$p_id = $_POST['pack_p_id'];
			$pa_price = get_var_query("select pk_price from package where pk_id = $pk_id");
			$pa_date = jdate('Y/m/d');
			$pa_details = "خرید بسته";
			$pa_type = $_POST['pa_type'];
			ex_query("insert into payment(p_id, pa_price, pa_date, pa_details, pa_type) values($p_id, '$pa_price', '$pa_date', '$pa_details', '$pa_type')");
			echo "<div class='alert alert-success'>هزینه بسته با موفقیت پرداخت شد</div>";
		}

		if(isset($_POST['del-payment'])){
			$pa_id = $_POST['del-payment'];
			ex_query("delete from payment where pa_id = $pa_id");
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

		if(isset($_POST['del-game'])){
			$g_id = $_POST['del-game'];
			ex_query("delete from game where g_id = $g_id");
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

		if(isset($_POST['del-package'])){
			$bp_id = $_POST['del-package'];
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

		if(isset($_POST['del-factor'])){
			$f_id = $_POST['del-factor'];
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
		<hr>
		
		<h3>ثبت پرداخت</h3>
		<hr>
		<form method="post" action="" class="form">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<label>نام شخص</label>
					<select name="p_id" class="select2 form-control">
						<?php
						$items = get_select_query("select * from person");
						foreach($items as $item){
						?>
						<option <?php if($item['p_id']==$p_id)echo "selected"; ?> value="<?php echo $item['p_id']; ?>"><?php echo $item['p_name'] . " " . $item['p_family']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3 col-sm-6">
					<label>مبلغ</label>
					<input name="pa_price" class="form-control" type="text" placeholder="مبلغ...">
				</div>
				<div class="col-md-3 col-sm-6">
					<label>توضیحات</label>
					<input name="pa_details" class="form-control" type="text" placeholder="توضیحات...">
				</div>
				<div class="col-md-3">
					<label>نحوه پرداخت</label>
					<select name="pa_type" class="form-control">
						<option>کارت</option>
						<option>نقد</option>
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
		
		<hr>
	
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
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$n = 0;
						$k = 0;
						if(isset($_POST['search'])){
							$p_id = $_POST['p_id'];
							$dt = $_POST['year'] . "/" . $_POST['month'];
							$sql = "select * from payment where p_id = $p_id and pa_date like '%" . $dt . "%' order by pa_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_GET['show-all'])){
							$p_id = $_GET['p_id'];
							$sql = "select * from payment where p_id = $p_id order by pa_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_POST['search']) || isset($_GET['show-all'])){
							if(count($res)>0){
								foreach($res as $row){ ?>
										<tr>
										<?php
										if($row['pa_type']=="نقد"){
											$n += $row['pa_price'];
										}else if($row['pa_type']=="کارت"){
											$k += $row['pa_price'];
										}
										?>
											<td><?php echo per_number($i); ?></td>
											<td><?php echo per_number(number_format($row['pa_price'])); ?> تومان</td>
											<td><?php echo per_number($row['pa_date']); ?></td>
											<td><?php echo per_number($row['pa_details']); ?></td>
											<td><?php echo $row['pa_type']; ?></td>
											<td>
												<form action="" method="post">
													<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-payment" value="<?php echo $row['pa_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
												</form>
											</td>
										</tr>
									<?php
									$i++;
								}
								?>
								<tr style="font-size: 20px;">
									<th colspan="2">جمع پرداخت نقد: </th>
									<td><?php echo per_number(number_format($n)); ?> تومان</td>
									<th colspan="2">جمع پرداخت کارتخوان: </th>
									<td><?php echo per_number(number_format($k)); ?> تومان</td>
								</tr>
							<?php
							} else { ?>
								<tr><td class="text-center" colspan="6">موردی جهت نمایش موجود نیست</td></tr>
							<?php
							}
						}
						?>
					</table>
				</div>
			</div>

			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h4 class="panel-title">جدول گزارش حضور</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>ساعت ورود</th>
							<th>ساعت خروج</th>
							<th>تاریخ</th>
							<th>مبلغ</th>
							<td>مدیریت</td>
						</tr>
						<?php
						$i = 1;
						$h = 0;
						if(isset($_POST['search'])){
							$p_id = $_POST['p_id'];
							$dt = $_POST['year'] . "/" . $_POST['month'];
							$sql = "select * from game where p_id = $p_id and g_date like '%" . $dt . "%' order by g_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_GET['show-all'])){
							$p_id = $_GET['p_id'];
							$sql = "select * from game where p_id = $p_id order by g_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_POST['search']) || isset($_GET['show-all'])){
							if(count($res)>0){
								foreach($res as $row){
									$h += $row['g_price'];
									?>
										<tr>
											<td><?php echo per_number($i); ?></td>
											<td><?php echo per_number($row['g_in']); ?></td>
											<td><?php echo per_number($row['g_out']); ?></td>
											<td><?php echo per_number($row['g_date']); ?></td>
											<td><?php echo per_number(number_format($row['g_price'])); ?> تومان</td>
											<td>
												<form action="" method="post">
													<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-game" value="<?php echo $row['g_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
												</form>
											</td>
										</tr>
									<?php
									$i++;
								}
								?>
								<tr style="font-size: 20px;">
									<th colspan="3">جمع مبلغ: </th>
									<td colspan="3"><?php echo per_number(number_format($h)); ?> تومان</td>
								</tr>
							<?php
							} else { ?>
								<tr><td class="text-center" colspan="6">موردی جهت نمایش موجود نیست</td></tr>
							<?php
							}
						}
						?>
					</table>
				</div>
			</div>


			<div class="col-md-12">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h4 class="panel-title">جدول گزارش فروشگاه</h4>
					</div>
					<table class="table table-striped">
						<tr>
							<th>ردیف</th>
							<th>نام محصول</th>
							<th>مبلغ</th>
							<th>تاریخ</th>
							<th>مدیریت</th>
						</tr>
						<?php
						$i = 1;
						$f = 0;
						if(isset($_POST['search'])){
							$p_id = $_POST['p_id'];
							$dt = $_POST['year'] . "/" . $_POST['month'];
							$sql = "select * from factor where p_id = $p_id and f_date like '%" . $dt . "%' order by f_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_GET['show-all'])){
							$p_id = $_GET['p_id'];
							$sql = "select * from factor where p_id = $p_id order by f_id desc";
							$res = get_select_query($sql);
						}
						if(isset($_POST['search']) || isset($_GET['show-all'])){
							if(count($res)>0){
								foreach($res as $row){
									$f += $row['pr_price'];
									$pr_name = get_name("product", "pr_name", "pr_id", $row['pr_id']);
									?>
										<tr>
											<td><?php echo per_number($i); ?></td>
											<td><?php echo $pr_name; ?></td>
											<td><?php echo per_number(number_format($row['pr_price'])); ?></td>
											<td><?php echo per_number($row['f_date']); ?></td>
											<td>
												<form action="" method="post">
													<button onclick="if(!confirm('آیا از انجام این عملیات اطمینان دارید؟')){return false;}" name="del-factor" value="<?php echo $row['f_id']; ?>" class="btn btn-danger btn-sm">حذف</button>
												</form>
											</td>
										</tr>
									<?php
									$i++;
								}
								?>
								<tr style="font-size: 20px;">
									<th colspan="2">جمع مبلغ: </th>
									<td colspan="3"><?php echo per_number(number_format($f)); ?> تومان</td>
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