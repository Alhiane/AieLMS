<?php

include 'connect.php';

$tpl ='includes/templates/';
$func = 'includes/functions/';
$layoutcss ='layout/css/';
$layoutjs ='layout/js/';


//
include $func . 'functions.php';
include $tpl . 'header.php';
if (!isset($noUpper)) {
	include $tpl . 'upper.php';
}
if (!isset($noNavbar)) {
	
	include $tpl . 'navbar.php';
}


?>