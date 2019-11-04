<?php	
	session_start();	
	if (isset($_SESSION['ADname'])) {
	$pageTitle = 'Dashboard';	
	include 'init.php';	

	/*Start Dashboard */
	
?>

<div class="container">
<!-- START Dashbord Stats -->
	 <div class="row states">
	 	<div class="state">
	 		<i class="fa fa-users" style="background-color: red"></i>
	 		<div class="info">
	 			<span><?php echo countItems('ID', 'users'); ?></span><p> Users</p>
	 		</div>
	 		<div class="bar" style="background-color: red"></div>
	 	</div>
	 	<div class="state">
	 		<i class="fa fa-book" style="background-color: #ffb700"></i>
	 		<div class="info">
	 			<span><?php echo countItems('ID', 'books'); ?></span><p>Books</p>
	 		</div>
	 		<div class="bar" style="background-color: #ffb700"></div>
	 	</div>
	 	<div class="state">
	 		<i class="fa fa-cloud-upload" style="background-color: #a2db13"></i>
	 		<div class="info">
	 			<span class="Totale-download">55</span><p>Books</p>
	 		</div>
	 		<div class="bar" style="background-color: #a2db13"></div>
	 	</div>
	 	<div class="state last">
	 		<i class="fa fa-eye" style="background-color: #0ba4d9"></i>
	 		<div class="info">
	 			<span>55</span><p>Books</p>
	 		</div>
	 		<div class="bar" style="background-color: #0ba4d9"></div>
	 	</div>
	 </div>  
	 <!---->
	 <div class="row states st2">
	 	<!---->
	 	<div class="charts">
	 		
	 	</div>
	 	<!---->
	 	<div class="states other">

		 	<div class="state other">
		 		<i class="fa fa-cloud-upload" style="background-color: #129400"></i>
		 		<div class="info xl">
		 			<span class="Totale-download"><a href="books.php?do=Manage&page=WaitingAproval"><?php echo checkItem('aprove', 'books', 0); ?></a></span><p class="wa">Books <br> (Waiting Aproval)</p>
		 		</div>
		 		<div class="bar" style="background-color: #129400"></div>
		 	</div>

		 	<div class="state other">
		 		<i class="fa fa-users" style="background-color: #872e2e"></i>
		 		<div class="info xl">
		 			<span><a href="members.php?do=Manage&page=WaitingAproval"><?php echo checkItem('Regstatus', 'users', 0); ?></a></span><p class="wa">Users <br> (Waiting Aproval)</p>
		 		</div>
		 		<div class="bar" style="background-color: #872e2e"></div>
		 	</div>
		 	

		 </div>	
	 	<!---->
	 </div>
<!-- End Dashbord Stats -->	 
</div>


<?php

	include $tpl . 'footer.php';

} else {

	header('Location: login.php');

	exit();

}

?>