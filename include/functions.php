<?php
function timeDiff($time2, $time1){
	$list2 = explode('/', $time2);
    $time2 = jalali_to_gregorian($list2[0], $list2[1], $list2[2], '-');
    $list1 = explode('/', $time1);
    $time1 = jalali_to_gregorian($list1[0], $list1[1], $list1[2], '-');
    $diff = strtotime($time2) - strtotime($time1);
	return ($diff / 3600) / 24;
}

function add_to_datee($datee, $add){
	$list2 = explode('/', $datee);
    $date2 = jalali_to_gregorian($list2[0], $list2[1], $list2[2], '-');
   	return jdate('Y/m/d', strtotime($date2 . ' + ' . $add . ' days'));
}

function convert_time($time){
	$display_used_time_list = explode(".", $time);
	$c = count($display_used_time_list);
	if($c==2){
		$display_used_time = round($display_used_time_list[0]) . ":" . round(($display_used_time_list[1] * 60) / 100);
		return $display_used_time;
	}else{
		return $time;
	}
}

function round_price($num){
	$p = strlen((string)$num);
	$o = (floor($num/100)) * 100;
	return $o;
}

function get_price($g_id, $p_id, $used_time, $total_shop){
	
	$t = get_person_status($p_id);
	if($t>=0){
		echo "<div class='col-md-12'><div class='alert alert-success text-center'><b>تراز:</b> " . per_number(number_format($t)) . "</div></div>";
	}else{
		echo "<div class='col-md-12'><div class='alert alert-danger text-center'><b>تراز:</b> " . per_number(number_format($t)) . "</div></div>";
	}
	
	
	//تعداد نفرات
	$g_count = get_var_query("select g_count from game where g_id = $g_id");
	
	if($used_time>0){
		$display_used_time = convert_time($used_time);
	}else{
		$display_used_time = $used_time;
	}
	
	echo "<div class='col-md-6'><div class='alert alert-info text-center'><b>افراد: </b> " . per_number($g_count) . "</div></div><hr>";
	echo "<div class='col-md-6'><div class='alert alert-info text-center'><b>جمع ساعت: </b> " . per_number($display_used_time) . "</div></div><hr>";

	
	$person = get_select_query("select * from person where p_id = $p_id");
	$p_sharj = $person[0]['p_sharj'];
	$p_pack = $person[0]['p_pack'];
	$p_expire = $person[0]['p_expire'];

	$total_price = 0;
	$last = 0;
	$has_bon = 0;
	$ezafe = 0;
	
	$pk_hour1 = 0;
	$pk_hour2 = 0;
		
	$now = jdate('Y/m/d');
	if($p_expire=="" || $p_expire==0){
		$diff = 0;
	}else{
		$diff = timeDiff($p_expire, $now);
	}
	
	if($diff<=0){
		if($p_pack==0 || $p_expire==0 || $diff<=0){	
			$end = 0;
			$used_time += $ezafe;
			$pk_hour1 = get_option('opt_hour1');
			$pk_hour2 = get_option('opt_hour2');
			if($p_pack==0)
				$label = "بدون اشتراک";
			else
				$label = "اتمام تاریخ اشتراک";
			echo "<div class='col-md-6'><div class='alert alert-danger text-center'>" . $label . "</div></div>";
			echo "<div class='col-md-6'><div class='alert alert-warning text-center'><b>بسته: </b> آزاد</div></div>";
			$u = $used_time;

			
			if($used_time>1){
				$u = $used_time-1;
				$total_price += ($u * $pk_hour2);
				$total_price += $pk_hour1;
			}else{
				$total_price += ($used_time * $pk_hour1);
			}
			
		}
	}else{
		$has_bon = 1;
		$package = get_select_query("select * from package where pk_id = $p_pack");
			
		if(count($package)>0){
			$pk_name = $package[0]['pk_name'];
			if($p_sharj<$used_time){
				$ezafe = $used_time - (abs($p_sharj));
				$end = 0;
			}else{
				$ezafe = 0;
				$end = $p_sharj - ($used_time * $g_count);
			}
			
			$pk_hour1 = $package[0]['pk_hour1'];
			$pk_hour2 = $package[0]['pk_hour2'];
			echo "<div class='col-md-6'><div class='alert alert-success text-center'>بسته معتبر</div></div>";
			echo "<div class='col-md-6'><div class='alert alert-warning text-center'><b>بسته: </b> " . $pk_name . "</div></div>";
			echo "<div class='col-md-6'><div class='alert alert-warning text-center'><b>انقضا: </b>" . per_number($p_expire) . "</div></div>";
			echo "<div class='col-md-6'><div class='alert alert-warning text-center'><b>شارژ باقی مانده: </b>" . per_number(convert_time($end)) . "</div></div>";
			$total_price = 0;
		}else{
			echo "<div class='col-md-12'><div class='alert alert-danger text-center'>اشتراک این شخص هنوز اعتبار دارد ولی نوع بسته آزاد تعریف شده است</div>";
		}
	}
	
	
	echo "<div class='col-md-12'><div class='alert alert-info text-center'><b>ورودی: </b>" . per_number(number_format($pk_hour1)) . " تومان | <b>هر ساعت: </b>" . per_number(number_format($pk_hour2)) . " تومان </div></div><br>";
	
	
	if($ezafe>0){
		$ezafe_price = round_price(($ezafe * $g_count) * get_option('opt_hour2'));
	}else{
		$ezafe_price = 0;
	}
	
	$total_price = round_price($total_price * $g_count);
	
	$total_all = round_price($total_price + $total_shop + $ezafe_price);
	
	ex_query("update game set g_price = $total_price where g_id = $g_id");
	if($has_bon==0){
		echo "<div class='col-md-6'><div class='alert alert-success text-center'><b>هزینه حضور: </b>" . per_number(number_format($total_price)) . "</div></div>";
		echo "<div class='col-md-6'><div class='alert alert-success text-center'><b>جمع خوراکی: </b>" . per_number(number_format($total_shop)) . "</div></div>";
	}else{
		echo "<div class='col-md-12'><div class='alert alert-success text-center'><b>جمع خوراکی: </b>" . per_number(number_format($total_shop)) . "</div></div>";
	}
	
	
	if($ezafe>0){
		echo "<div class='col-md-12'><div class='alert alert-danger text-center'><b>جمع اضافه: </b>" . per_number(convert_time($ezafe)) . " ساعت = " . per_number(number_format($ezafe_price)) . "</div></div>";
	}
	
	
	echo "<hr><h4 class='col-md-12'>ثبت پرداخت</h4>";
	?>
	<div class="row">
		<div class="col-md-4">
			<input type="hidden" class="form-control" id="pay_p_id" value="<?php echo $p_id ?>">
			<label>مبلغ</label>
			<input type="text" class="form-control" id="pay_price" value="<?php echo $total_all; ?>">
		</div>
		<div class="col-md-4">
			<label>نوع پرداخت</label>
			<select id="pay_type" class="form-control">
				<option>کارت</option>
				<option>نقد</option>
			</select>
		</div>
		<div class="col-md-4"><br>
			<button id="pay" class="btn btn-success btn-lg">پرداخت</button>
		</div><br>
		<div class="col-md-12" id="pay-result"></div>
	</div>
	<hr>
	<button id="set-out" class="btn btn-danger btn-lg" data-ezafe="<?php echo $ezafe_price * $g_count; ?>" data-pack="<?php echo $p_pack; ?>" data-last="<?php echo $end; ?>" data-gid="<?php echo $g_id; ?>">ثبت خروج</button>
	<?php
}

function load_light_factor($p_id){ ?>
	<table class="table table-striped text-center">
		<tr>
			<th class="text-center">ردیف</th>
			<th class="text-center">نام کالا</th>
			<th class="text-center">قیمت</th>
			<th class="text-center">حذف</th>
		</tr>
			<?php
			$i = 1;
			$total = 0;
			$res = get_select_query("select * from factor where p_id = $p_id and f_status = 0");
			foreach($res as $row){
				$pr_name = get_name("product", "pr_name", "pr_id", $row['pr_id']); ?>
			<tr>
				<td><?php echo per_number($i); ?></td>
				<td><?php echo $pr_name; ?></td>
				<td><?php echo per_number(number_format($row['pr_price'])); ?></td>
				<td><button data-fid="<?php echo $row['f_id']; ?>" data-pid="<?php echo $row['p_id']; ?>" class="remove-from-factor btn btn-danger btn-sm">حذف</button></td>
			</tr>
			<?php
			$total += $row['pr_price'];
			$i++;
			}
		?>
		<tr>
			<th></th>
			<th style="text-align: center">جمع کل: </th><th style="text-align: center"><?php echo per_number(number_format($total)); ?></th>
			<th></th>
		</tr>
	</table>
<?php
}

function load_factor($g_id, $p_id){ ?>
	<table class="table table-striped text-center">
		<tr>
			<th class="text-center">ردیف</th>
			<th class="text-center">نام کالا</th>
			<th class="text-center">قیمت</th>
		</tr>
			<?php
			$i = 1;
			$total = 0;
			$res = get_select_query("select * from factor where p_id = $p_id and f_status = 0");
			foreach($res as $row){
				$pr_name = get_name("product", "pr_name", "pr_id", $row['pr_id']);
				?>
			<tr>
				<td><?php echo per_number($i); ?></td>
				<td><?php echo $pr_name; ?></td>
				<td><?php echo per_number(number_format($row['pr_price'])); ?></td>
			</tr>
			<?php
			$total += $row['pr_price'];
			$i++;
			}
		?>
		<tr>
			<th></th>
			<th style="text-align: center">جمع کل: </th><th style="text-align: center"><?php echo per_number(number_format($total)); ?></th>
		</tr>
	</table>
	<?php
	echo "<hr>";
	$g_in = get_var_query("select g_in from game where g_id = $g_id");
	
	$now = jdate('H:i');
	

	$to_time = strtotime($g_in);
	$from_time = strtotime($now);
	$diff = round(abs($to_time - $from_time) / 3600, 2);

	$price = get_price($g_id, $p_id, $diff, $total);

	ex_query("update game set g_out = '$now' where g_id = $g_id");
}


function get_option($key){
	$res = get_var_query("select meta_value from setting where meta_key = '$key'");
	return $res;
}

function save_option($key, $value){
	$check = get_select_query("select * from setting where meta_key = '$key'");
	if(count($check)>0){
		ex_query("update setting set meta_value = '$value' where meta_key = '$key'");
	}else{
		ex_query("insert into setting(meta_key, meta_value) values('$key', '$value')");
	}
}

function calc_pay_status($p_id){
	
	$bp_total = get_var_query("select sum(pk_price) from package inner join buy_package on package.pk_id = buy_package.pk_id where p_id = $p_id");
	$f_total = get_var_query("select sum(pr_price) from factor where p_id = $p_id and f_status = 1");
	$h_total = get_var_query("select sum(g_price) from game where p_id = $p_id");
	
	$used_total = $bp_total + $f_total + $h_total;
	
	

	$p_total = get_var_query("select sum(pa_price) from payment where p_id = $p_id");

	$t = $p_total - $used_total;
	
	if($t < 0)
		echo "<span style='background: red; color: #fff'>" . per_number(number_format($t)) . "</span>";
	else
		echo "<span style='background: #00e732; color: #fff'>" . per_number(number_format($t)) . "</span>";
}

function get_person_status($p_id){
	
	$bp_total = get_var_query("select sum(pk_price) from package inner join buy_package on package.pk_id = buy_package.pk_id where p_id = $p_id");
	$f_total = get_var_query("select sum(pr_price) from factor where p_id = $p_id and f_status = 1");
	$h_total = get_var_query("select sum(g_price) from game where p_id = $p_id");
	
	$used_total = $bp_total + $f_total + $h_total;
	
	$p_total = get_var_query("select sum(pa_price) from payment where p_id = $p_id");

	$t = $p_total - $used_total;
	
	return $t;
}

function send_sms($mobile, $msg){
	
	$url = "37.130.202.188/services.jspd";
		
	$rcpt_nm = array($mobile);
	$param = array(
		'uname'=>'09133933505',
		'pass'=>'3505',
		'from'=>'+985000125475',
		'message'=>$msg,
		'to'=>json_encode($rcpt_nm),
		'op'=>'send'
	);				
	$handler = curl_init($url);
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	$response2 = curl_exec($handler);
		
	$response2 = json_decode($response2);
	$res_code = $response2[0];
	$res_data = $response2[1];
}

function send_sms_all($msg){
	
	$url = "37.130.202.188/services.jspd";
	$rcpt_nm = array("09138630341", "09138630341");
	
	/*$list = get_select_query("select p_mobile from person");
	foreach($list as $l){
		if($l['p_mobile']!=""){
			array_push($rcpt_nm, $l['p_mobile']);
		}
	}
	*/
	$param = array(
		'uname'=>'mahdavi1456',
		'pass'=>'m54692764o',
		'from'=>'+985000125475',
		'message'=>$msg,
		'to'=>json_encode($rcpt_nm),
		'op'=>'send'
	);				
	$handler = curl_init($url);
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	$response2 = curl_exec($handler);
		
	$response2 = json_decode($response2);
	$res_code = $response2[0];
	$res_data = $response2[1];
	return $res_data;
}

function send_sms1($msg, $rcpts){
	
	$url = "37.130.202.188/services.jspd";
	
	$rcpt_nm = array();
	
	$list = explode(",", $rcpts);
	foreach($list as $l){
		array_push($rcpt_nm, $l);
	}
	
	$param = array(
		'uname' => get_option('sms_user'),
		'pass' => get_option('sms_pass'),
		'from' => get_option('sms_line'),
		'message' => $msg,
		'to' => json_encode($rcpt_nm),
		'op' => 'send'
	);				
	$handler = curl_init($url);
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	$response2 = curl_exec($handler);
		
	$response2 = json_decode($response2);
	$res_code = $response2[0];
	$res_data = $response2[1];
	return $res_data;
}

function get_sms_credit(){
	$url = "37.130.202.188/services.jspd";
	$param = array(
		'uname' => get_option('sms_user'),
		'pass' => get_option('sms_pass'),
		'op' => 'credit'
	);
	$handler = curl_init($url);             
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	$response2 = curl_exec($handler);
		
	$response2 = json_decode($response2);
	$res_code = $response2[0];
	$res_data = $response2[1];
	if($res_data=="the username or password is incorrect"){
		echo "تنظیمات پیامک اشتباه وارد شده است";
	}else{
		echo "شارژ پیامک شما: " . per_number(number_format(round($res_data/10))) . " تومان";
	}
}
?>