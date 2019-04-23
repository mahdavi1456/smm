<?php
function get_user_type($username){
	$user_type = get_select_query("select user_type from users where username='$username'");
	return $user_type;
}

function get_user_id($username){
	$user_id = get_select_query("select ID from users where username='$username'");
	return $user_id;
}

function is_admin($level){
	if($level=="مدیر")
		return true;
	else
		return false;
}

?>