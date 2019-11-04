<?php 
	// Ajax request for Settings page (save/update/delete)
	$noNavpag ='';
	$noNavbar ='';
	$noUpper = '';
	include 'init.php';

	$req = $_POST['reqType'];
	echo $req;

	if ($req == 'gen') { // if the request coming from  tab generale in settings page
		// get information $formerrors[] $formerrors = array();
		$title = strip_tags($_POST['title']);
		$desc  = strip_tags($_POST['desc']);
		$logo  = $_FILES['logo'];
		$icon  = strip_tags($_POST['icon']);

		print_r($logo);

		// prepared logo
		/*$logoName =  $_POST['img']['name']; 
		$logoSize =  $_POST['img']['size']; 
		$logoTmp =   $_POST['img']['tmp_name']; 
		$logoType =  $_POST['img']['type']; 
		$logoError = $_POST['img']['error']; 

		// prepared icon
		$iconName =  strip_tags($_POST['icon']['name']); 
		$iconSize =  strip_tags($_POST['icon']['size']); 
		$iconTmp =   strip_tags($_POST['icon']['tmp_name']); 
		$iconType =  strip_tags($_POST['icon']['type']); 
		$iconError = strip_tags($_POST['icon']['error']); 

		// checked errors before uploade
		if($logoError == 0) {

			$logoAllowedExetention = array("jpg", "jpeg", "png", "gif");

			@$logoExetention =strtolower(end(explode('.', $logoName))); 

			@$logo = rand(0, 1000000) . '_' . $logoName;

			move_uploaded_file($logoTmp, "Admin/layout/images/avatar/" . $logo);

			@$stmt = $con->prepare("UPDATE settings SET logo = ?");
        	@$stmt->execute(array($logo));

        	if($stmt->rowCount() > 0) {
        		echo "logo update";
        	}

		}*/


		



	} elseif ($req == 'admins') {

	}
	
 ?>