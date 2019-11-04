<?php
	session_start();
	$pageTitle = 'About Us';
    include 'init.php';

?>

<div class='container'>
	<div class="aboutus">
		<h2> About Us </h2> <span> Last Update : 2018 / 20 / 15 </span>
		<i class="fa fa-quote-left"></i><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		 tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		 quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		 consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		 cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		 proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		 Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		  proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p><i class="fa fa-quote-right"></i>
			
		  <?php $stmt= $con->prepare("SELECT * From users where GroupId = 1"); 
		  		$stmt->execute();
		  		$rows = $stmt->fetchAll(); ?>		  		
		  <div class="team">
		  	<h2> Teame </h2>
		  	<?php foreach ($rows as $row) { ?>
		  	<div class="each">		  		
	  			<img src="Admin/layout/images/avatar/<?php echo $row['Avatar'] ?>"> 	
	  			<h4> <?php echo $row['Fullname']; ?> <span><?php echo $row['Email']; ?></span> </h4>	

		  	</div>
		  	<?php } ?>
		  </div>		  
	</div>
</div>
<?php include $tpl . 'mainfooter.php'; ?>
<?php include $tpl . 'footer.php'; ?>