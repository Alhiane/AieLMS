<?php
session_start();
$pageTitle = 'Index';
$Navbar="";
$noNavpag = '';
include 'init.php';
?>

	<!-- swap section -->	
	<!-- tart Header Content -->

	<div class="header">
		<div class="overlay">
			<div class="container ctt">
				<div class="logo">
					<img src="layout/images/avatar/logo.png">					
				</div>
				<div class="search">
					<form action="search.php" method="POST">
						<div class="row">
							<input type="search" name="areasearch" id="areasearch" placeholder="enter any Tags,Titles,Names To start reserch" class="form-control col-md-6">
							<button class="btn btn-success"><i class="fa fa-search"></i></button>
						</div>	
					</form>
				</div>
			</div>
		</div>

	<!-- Start Slider Top 10 Downloads -->

	<div class="td10">	
		<div class="container-fluid  topdown">
			<div class="owl-carousel">			
				<?php 

					/* Get Books From DB Order by High Downloades */
					$st = $con->prepare("SELECT * FROM books WHERE aprove = 1 Order by Downloadconter  DESC LIMIT 7");
					$st->execute();
					$items = $st->fetchAll();

					foreach ($items as $book) { ?>
						<?php $catid = $book['cat_id']; ?>
						<!-- Select Category By Id -->
						<?php $st2 = $con->prepare("SELECT * FROM categories WHERE ID = ?");
							  $st2->execute(array($catid));
							  $rows = $st2->fetchAll();  
							  ?>
						<!-- End Select Category By Id -->
						<div class="book">
							<img  src="Admin/layout/images/books/<?php echo $book['avatar']?>">
							<!-- Get Category -->
							<?php foreach ($rows as $row) {
								?>
								<span class="Categorey"><?php echo $row['Name']; ?></span>
								<?php
							} ?>
							<!-- End Get Category -->
							<div class="detail">					
								<h4><a href="books.php?id=<?php echo $book['ID']?>&title=<?php echo str_replace(' ', '-', $book['title'])?>"   ><?php echo substr($book['title'],0,40)?></a></h4>
								<h6 class="desc" > <?php echo substr($book['description'],0,80) . "..."?> </h6>
								<h6 class="pages">Pages: 115</h6>
								<h6 class="size" ><?php echo substr($book['size'],0,4) . ' MB'; ?></h6>
							</div>
							<div class="footer">
								<span class="counter"><i class="fa fa-cloud-download"></i> +<?php echo $book['Downloadconter']; ?></span>
								<?php $userid = $book['member_id']; ?>
								<?php $st3  = $con->prepare("SELECT * FROM users WHERE ID = ?");
											    $st3->execute(array($userid));
											    $users = $st3->fetchAll();
											    ?>
								<?php foreach ($users as $user) {
									?>
										<span class="useravatar">
										<?php if(!empty($user['Avatar'])){ ?>	
											<img class="avatar" src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>">
										<?php }else{ ?>
											<img class="avatar" src="Admin/layout/images/avatar/avatar.jpg">
										<?php } ?>	
											<?php echo $user['Username'] ?></span>					
									<?php
								} ?>
							</div>
						</div>							
					        
			        <?php } ?>				
			</div>
		</div>	
	</div>

	<!-- End Slider Top 10 Downloads -->

	<!-- About library -->
	<div class="about">
		<div class="container">
			<div class="row">
				<?php $stmt = $con->prepare("SELECT * from books");
					  $stmt->execute();
					  $dets = $stmt->fetch();
					  $count = $stmt->rowCount();
					   ?>
				<!-- book counter -->
				<div class="each col-md-3">
					<!-- icon -->
					<i class="fa fa-book"></i>
					<!-- simple description -->
					<p> More Than <span> <?php echo $count ?> </span> books issus </p>
				</div>
				<?php $stmt1 = $con->prepare("SELECT * from users");
					  $stmt1->execute();
					  $uss = $stmt1->fetch();
					  $countus = $stmt1->rowCount();
					   ?>
				<!-- usersactif counter -->
				<div class="each col-md-3">
					<!-- icon -->
					<i class="fa fa-users"></i>
					<!-- simple description -->
					<p> More Than <span> <?php echo $countus ?> </span> users  actife every month </p>
				</div>

				<!-- langs -->
				<div class="each col-md-3">
					<!-- icon -->
					<i class="fa fa-language"></i>
					<!-- simple description -->
					<p> The books Avilabel More Thane<span> 8 </span> Languges </p>
				</div>
				<?php $stmt2 = $con->prepare("SELECT Downloadconter from books");
					  $stmt2->execute();
					  $dws = $stmt2->fetchAll();
					  $all = 0;					  					  
					  	foreach ($dws as $dw) {
					  		$all = $all + $dw['Downloadconter'];
					  	}					  
					   ?>
				<!-- Downloads counter -->
				<div class="each col-md-3">
					<!-- icon -->
					<i class="fa fa-cloud-download"></i>
					<!-- simple description -->
					<p> More Thane <span> <?php echo $all ?> </span> Time Downloades </p>
				</div>
			</div>
		</div>
	</div>
	<!-- About library -->

	</div>	

	<!-- End Header Content -->
	<div class="clearfix"></div>	

	<!-- Home Books -->

	<div class="container">
		<div class="home-books">
			<div class="row" id="data_pagination">			
				<meta charset="utf-8">

			</div>
		</div>
	</div>
	<!-- End Home Books -->
	<!-- Banner Ads -->
	<div class="ads-home container">
		ADS
	</div>
	<!-- Banner Ads -->
	<!-- Start body (Categories Tabs) Content -->
	<div class="cat-tabs">
		<div class="container">
			<ul class="classic-list catename">
			
				<?php

				$stmt = $con->prepare("SELECT * FROM categories WHERE Parent = 0 LIMIT 5");
				$stmt->execute();
				$rows = $stmt->fetchAll();

				foreach ($rows as $row) { ?>
				<li class="selected" data-class="<?php echo str_replace(' ','-',$row['Name'])?>"><?php echo $row['Name']?></li>
				<?php } ?>				
			</ul>
			<div class="catcontent">	
			<?php foreach ($rows as $row) { ?>	
				<div class="<?php echo str_replace(' ','-',$row['Name']) .' '. "books"?>">

					<?php
					$cat = $row['ID'];
					$stmt2 = $con->prepare("SELECT * FROM books WHERE cat_id = ? And aprove = 1 Order by ID DESC LIMIT 5");
					$stmt2->execute(array($cat));
					$books = $stmt2->fetchAll();

					foreach ($books as $book) { ?>
					
					<div class="book">
						<img  src="Admin/layout/images/books/<?php echo $book['avatar']?>">
						<span class="Categorey"><?php echo $row['Name']?></span>
						<div class="detail">					
							<h4><a  href="books.php?id=<?php echo $book['ID']?>&title=<?php echo str_replace(' ', '-', $book['title'])?>"   > <?php echo substr($book['title'],0,40)?> </a></h4>
							<h6 class="desc" > <?php echo substr($book['description'],0,80) . "..."?></h6>
							<h6 class="pages">Pages: 115</h6>
							<h6 class="size" > <?php echo substr($book['size'],0,4). " MB"?></h6>
						</div>
						<div class="footer">
							<span class="counter"><i class="fa fa-cloud-download"></i> +<?php echo substr($book['Downloadconter'],0,11)?></span>
							<?php
							$uid = $book['member_id'];
							$stmt3 = $con->prepare("SELECT * FROM users WHERE ID = ?");
							$stmt3->execute(array($uid));
							$users = $stmt3->fetchAll();

							foreach ($users as $user) { ?>
							<span class="useravatar">
							<?php if (!empty($user['Avatar'])) { ?>	
								<img class="avatar" src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>">
							<?php }else{ ?>
								<img class="avatar" src="Admin/layout/images/avatar/avatar.jpg">
							<?php } ?>	
								<?php echo $user['Username']?>
							</span>
							<?php } ?>	
						</div>
					</div>												

					<?php } ?>	
					<a class="more" href="categories.php?id=<?php echo $row['ID']?>&pagename=<?php echo str_replace(' ', '-', $row['Name'])?>"><button class="btn btn-success btn-block"><i class="fa fa-spinner"></i> More From <?php echo $row['Name']?></button></a>						
				</div>	
				<?php } ?>						
			</div>
		</div>
	</div>	

<!-- End   body (Categories Tabs) Content -->

<div class="clearfix"></div>
<?php include $tpl . 'mainfooter.php'; ?>	
<?php include $tpl.'footer.php'; ?>