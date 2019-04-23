<?php include"header.php"; ?>
	
	<div class="container-fluid">
		<h2>ارسال پیامک
			
			<a target="_blank" style="float: left; margin: 0px 10px;" href="http://sms.gratech.ir/" class="btn btn-info">ورود به پنل سامانه</a>
			<a target="_blank" style="float: left; margin: 0px 10px;" href="http://sms.gratech.ir/" class="btn btn-success">شارژ پیامک</a>
			<span style="float: left; font-size: 22px; margin: 5px 10px;"><?php get_sms_credit(); ?></span>
		</h2>
		<hr>
		<form method="post" action="" class="form" onSubmit="if(!confirm('آیا از ارسال این پیامک اطمینان دارید؟')){return false;}">
			<?php
			if(isset($_POST['send_sms'])){
				
				if($_POST['send_type']!="-"){
					$sms_text = $_POST['sms_text'];
				
					$sl_user = $_SESSION['user_id'];
					$sl_date = jdate('Y/m/d H:i');
					$sl_line = get_option('sms_line');
					$sl_text = $sms_text;
				
					if($_POST['send_type']==0){
						$rcpts0 = $_POST['rcpts0'];
						$sl_rcpts = $rcpts0;
						$sl_bulk = send_sms1($sms_text, $rcpts0);
					} else if($_POST['send_type']==1){
						$rcpts1 = $_POST['rcpts1'];
						$sl_rcpts = $rcpts1;
						$sl_bulk = send_sms1($sms_text, $rcpts1);
					} else if($_POST['send_type']==2){
						$rcpts2 = $_POST['rcpts2'];
						$sl_rcpts = $rcpts2;
						$sl_bulk = send_sms1($sms_text, $rcpts2);
					}
				
					ex_query("insert into sms_log(sl_user, sl_date, sl_line, sl_bulk, sl_rcpts, sl_text) values($sl_user, '$sl_date', '$sl_line', $sl_bulk, '$sl_rcpts', '$sl_text')");
					?>
					<div class="alert alert-success">پیامک با موفقیت ارسال شد.</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">لطفا مخاطبین دریافت پیامک را انتخاب کنید</div>
					<?php
				}
			}
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-success">
						<div class="panel-heading">گیرندگان پیامک</div>
						<div class="panel-body">
							<div class="col-md-3">
								<label>نوع مخاطبین</label>
								<select id="send-type" name="send_type" class="form-control">
									<option value="-">انتخاب گیرندگان</option>
									<option value="0">همه مشتریان</option>
									<option value="1">یک مشتری خاص</option>
									<option value="2">شماره دلخواه</option>
								</select>
							</div>					
							<div class="col-md-9">
								<label>گیرندگان</label>	
								
								<div class="p-alt" id="p-1">
									<?php
									$list = get_select_query("select p_mobile from person");
									$rcpt_nm = array();
									foreach($list as $l){
										if($l['p_mobile']!=""){
											array_push($rcpt_nm, $l['p_mobile']);
										}
									}
									?>
									<textarea rows="3" class="form-control" name="rcpts0" id="rcpts"><?php echo implode(",", $rcpt_nm); ?></textarea>
									<label class="red" id="rcpts-num"><?php echo "تعداد شماره ها: " . count($rcpt_nm); ?></label>		
								</div>
								
								<div class="p-alt" id="p-2">
									<select style="width: 100%" name="rcpts1" class="select2 form-control">
										<?php
										$items = get_select_query("select * from person");
										foreach($items as $item){ ?>
										<option value="<?php echo $item['p_mobile']; ?>"><?php echo $item['p_name'] . " " . $item['p_family']; ?></option>
										<?php
										} ?>
									</select>
								</div>
								
								<div class="p-alt" id="p-3">
									<input type="text" name="rcpts2" class="form-control" placeholder="لطفا شماره های مورد نظر را به ترتیب وارد کنید و با , آن ها را جدا کنید">
								</div>
		
		
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">متن پیامک</div>
						<div class="panel-body">
							<textarea rows="5" id="sms_text" name="sms_text" value="" class="form-control" placeholder="متن پیامک..."></textarea>
						</div>
						<div class="panel-footer">
							تعداد پیامک: <label class="red" id="sms_page"></label>
							تعداد کاراکتر باقی مانده تا پیام بعدی: <label class="red" id="sms_size">70</label>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 text-center">
					<button name="send_sms" class="btn btn-info btn-lg">ارسال پیام</button>
				</div>
			</div>
			
			<br>
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-warning">
						<div class="panel-heading">گزارش پیامک های ارسال شده</div>
						<div class="panel-body">
							<table class="table table-success">
								<tr>
									<th>#</th>
									<th>کاربر</th>
									<th>تاریخ</th>
									<th>متن پیامک</th>
									<th>خط ارسالی</th>
									<th>گیرندگان</th>
									<th>کد بالک</th>
								</tr>
								<?php
								$i = 1;
								$res = get_select_query("select * from sms_log order by sl_id desc");
								if(count($res)>0){
									foreach($res as $row){ ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row['sl_user']; ?></td>
										<td><?php echo $row['sl_date']; ?></td>
										<td><?php echo $row['sl_text']; ?></td>
										<td><?php echo $row['sl_line']; ?></td>
										<td><?php echo $row['sl_rcpts']; ?></td>
										<td><?php echo $row['sl_bulk']; ?></td>
									</tr>
									<?php
									$i++;
									}
								} else { ?>
									<tr>
										<td colspan="7" class="text-center">موردی جهت نمایش موجود نیست</td>
									</tr>
								<?php
								} ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php include"footer.php"; ?>