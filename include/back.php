<?php
if(isset($_POST['add_to_datee'])){
	$datee = $_POST['datee'];
	$add = $_POST['add'];
	echo add_to_datee($datee, $add);
	exit();
}

if(isset($_POST['minus_from_datee'])){
	$datee2 = $_POST['datee2'];
	$datee1 = $_POST['datee1'];
	echo timeDiff($datee2, $datee1);
	exit();
}

if(isset($_POST['check_send_type'])){
	$send_type = $_POST['send_type'];
	$rcpt_nm = array();
	if($send_type==0){
		echo "0";
	} else if($send_type==1){		
		echo "1";
	} else if($send_type==2){
		echo "2";
	}
	exit();
}

if(isset($_POST['set_login'])){
	$p_code = $_POST['p_id'];
	$g_count = $_POST['g_count'];
	$p_id = get_var_query("select p_id from person where p_code = '$p_code'");
	if($p_id!=""){
		$g_in = jdate('H:i');
		$g_date = jdate('Y/m/d');

		$check = get_select_query("select * from game where p_id = $p_id and g_out is NULL");

		if(count($check) > 0){
			echo "<br><div class='alert alert-danger'>شما یک ورود دارید که هنوز خروج آن ثبت نشده است</div>";
		}else{
			ex_query("insert into game(p_id, g_count, g_in, g_date) values($p_id, $g_count, '$g_in', '$g_date')");
			echo "ok";
		}
	}else{
		echo "<br>";
		echo "<div class='alert alert-danger'>کاربری با این کد یافت نشد</div>";
	}
	exit();
}

if(isset($_POST['load_light_factor'])){
	$p_id = $_POST['p_id'];
	load_light_factor($p_id);
	exit();
}

if(isset($_POST['set_pro_to_cart'])){
	$p_id = $_POST['p_id'];
	$pr_id = $_POST['pr_id'];
	$f_count = 1;
	$pr_price = get_var_query("select pr_sale from product where pr_id = $pr_id");
	$pr_stock = get_var_query("select pr_stock from product where pr_id = $pr_id");
	$f_date = jdate('Y/m/d H:i');

	if($pr_stock>0){
		$pr_stock--;
		ex_query("update product set pr_stock = $pr_stock where pr_id = $pr_id");

		ex_query("insert into factor(p_id, pr_id, f_count, pr_price, f_date) values($p_id, $pr_id, $f_count, $pr_price, '$f_date')");

		load_light_factor($p_id);
	}else{
		echo "این کالا تمام شده است";
	}
	exit();
}

if(isset($_POST['remove_from_factor'])){
	$fid = $_POST['fid'];
	$pid = $_POST['pid'];
	$pr_stock = get_var_query("select pr_stock from product where pr_id = $pid");
	$pr_stock++;
	ex_query("update product set pr_stock = $pr_stock where pr_id = $pid");

	ex_query("delete from factor where f_id = $fid");
	load_light_factor($pid);
	exit();
}

if(isset($_POST['load_factor'])){
	$p_id = $_POST['pid'];
	$g_id = $_POST['gid'];
	load_factor($g_id, $p_id);
	exit();
}

if(isset($_POST['add_pay'])){
	$pay_p_id = $_POST['pay_p_id'];
	$pay_price = $_POST['pay_price'];
	$pay_type = $_POST['pay_type'];
	$pa_date = jdate('Y/m/d H:i');
	$pa_details = "بازی، خرید";
	ex_query("insert into payment(p_id, pa_price, pa_date, pa_details, pa_type) values($pay_p_id, '$pay_price', '$pa_date', '$pa_details', '$pay_type')");
	echo "<br><div class='alert alert-success'>پرداخت با موفقیت ثبت شد</div>";
	exit();
}

if(isset($_POST['get_package_info'])){
	$pk_id = $_POST['pk_id'];
	$res = get_select_query("select * from package where pk_id = $pk_id");
	$pk_time = $res[0]['pk_time'];
	$pk_expire = $res[0]['pk_expire'];
	$pk_price = $res[0]['pk_price'];
	echo $pk_time . "," . $pk_expire . "," . $pk_price;
	exit();
}

if(isset($_POST['set_out'])){
	$gid = $_POST['gid'];
	$last = $_POST['last'];
	$p_pack = $_POST['pack'];
	$ezafe = $_POST['ezafe'];
	
	$p_id = get_var_query("select p_id from game where g_id = $gid");
	
	ex_query("update game set g_status = 1 where g_id = $gid");	
	ex_query("update factor set f_status = 1 where p_id = $p_id");	
	
	if($ezafe>0){
		ex_query("update game set g_price = '$ezafe' where g_id = $gid");	
	}
	
	$mobile = get_var_query("select p_mobile from person where p_id = $p_id");
	if($p_pack==0){
		//send_sms($mobile, "ممنون از اینکه به خونه مادربزرگه سر زدید. \n میزان ساعت بازی فرزند شما: " . $last . " ساعت می باشد.");
	}else{
		ex_query("update person set p_sharj = $last where p_id = $p_id");
		send_sms($mobile, "ممنون از اینکه به خونه مادربزرگه سر زدید. \n مانده اعتبار بن شما: " . convert_time($last) . " ساعت می باشد.");
	}
	exit();
}
?>