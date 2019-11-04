<?php $noNavbar= ''; $noNavpag= ''; include 'init.php';
$req = $_REQUEST['reqType'];

if ($req == "userreq") {
	$user = $_REQUEST['user'];
	@$stmt = $con->prepare("SELECT Username FROM users WHERE Username = ?");
	@$stmt->execute(array($user));
	@$row = $stmt->fetch();
	@$count = $stmt->rowCount();

	if ($count > 0) {
	echo "This Username Really Exists Chose Unique Name";
	}
}else{
	
}
