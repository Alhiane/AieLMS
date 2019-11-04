<?php

	/*Function page title*/

	function getTitle(){

		global $pageTitle;

		if (isset($pageTitle)) {
			
			echo $pageTitle;

		} else {

			$pageTitle = 'Defulte';

		}
	}

/*function To Gett All From DATABASE  V 2.0*/

function gettAllfrom($filed, $table, $where = NULL){

	global $con;

	$gettAll = $con->prepare("SELECT $filed, FROM $table, $where");

	$gettAll->execute();

	$all = $gettAll->fetchAll();

	return $all;

}

/*function redirect home */


function redirectHome($theMsg,$url = null, $seconds = 3){

	if($url === null){

		$url='dashbord.php';
		$link='Home page';
	} else {

		$url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $url = $_SERVER['HTTP_REFERER'] : $url = 'dashbord.php';
		$link='Previous page';
	} 
	

	echo $theMsg;

	echo "<div class='alert alert-info'>You will be redirect to $link after $seconds seconds.</div>";

	header("refresh:$seconds;url=$url");

	exit();

}	 

	/* function check item exist in database*/
	
function checkItem($select, $from, $value){

	global $con;

	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

	$statement->execute(array($value));

	$count = $statement->rowCount();

	return $count;

}
	/* function to count item*/

	function countItems($Item, $Table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($Item) FROM $Table");

		$stmt2->execute();

		return $stmt2->fetchColumn();

}

	/* function get a latest register members*/
	
	function getLatest($select, $table, $order, $limit = 5){

		global $con;

		$getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getstmt->execute();

		$rows = $getstmt->fetchAll();

		return $rows;
}

?>