<?php

include 'Admin/connect.php';

$tpl ='includes/templates/';
$func = 'includes/functions/';
$layoutcss ='layout/css/';
$layoutjs ='layout/js/';


//
include $func . 'functions.php';
include $tpl . 'header.php';
if (isset($Navbar)) {
	
	include $tpl . 'nav.php';
}

if (!isset($noNavpag)) {
	
	include 'includes/templates/navpag.php';
}




?>