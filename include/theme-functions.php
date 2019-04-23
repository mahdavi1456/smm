<?php
function get_theme_dir(){
	require_once"functions.php";
	return get_option('opt_home');
}

function view_url($view){
	echo theme_dir() . $view;
}

function get_view_url($view){
	return get_theme_dir() . $view;
}

function get_full_url(){
	$fullurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $fullurl;
}

function check_active(){
	
}
?>