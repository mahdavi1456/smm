<?php
include"jdf.php";
function get_connection_string(){
    $pdo_conn = new PDO("mysql:host=localhost;dbname=helisoft;charset=utf8", 'root', '',
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    return $pdo_conn;
}

function ex_query($sql){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare($sql);
	$pdo_statement->execute();
}

function get_select_query($sql){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare($sql);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	return $result;
}

function get_var_query($sql){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare($sql);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if($result)
		return $result[0][0];
	else
		return;
}

function check_login($username, $password){
	$res = get_select_query("select * from users where username='$username' and password='$password'");
	return count($res);
}

function alert($type, $msg){
	?>
	<div class="alert alert-<?php echo $type; ?> alert-dismissible">
        <button type="button" class="close pull-left" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $msg; ?>
    </div>
	<?php
}

function get_product_name($id){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare("select name from product where ID=$id");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if(count($result)>0){
		return $result[0][0];
	}
}

function get_product_price($id){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare("select price from product where ID=$id");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if(count($result)>0){
		return $result[0][0];
	}
}

function get_customer_name($id){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare("select name, family from customer where ID=$id");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if(count($result)>0){
		return $result[0][0] . " " .$result[0][1];
	}
}

function get_user_name($id){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare("select namee, family from users where ID=$id");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if(count($result)>0){
		return $result[0][0] . " " .$result[0][1];
	}
}

function get_user_level($id){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare("select level from users where ID=$id");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if(count($result)>0){
		return $result[0][0];
	}
}

function per_number($number){
    return str_replace(
        range(0, 9),
        array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'),
        $number
    );
}

function eng_number($number){
    return str_replace(
        array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'),
        range(0, 9),
        $number
    );
}

function get_name($table, $field, $id_name, $id_val){
	$pdo_conn = get_connection_string();
	$pdo_statement = $pdo_conn->prepare("select $field from $table where $id_name = $id_val");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	if(count($result)>0){
		return $result[0][0];
	}
}
?>