<?php 
session_start();
@$pageTitle = str_replace('-',' ',$_GET['pagename']);
@$catid = $_GET['id'];
@$parent = $_GET['id'];
include 'init.php';
?>

<div class="clearfix"></div>
<?php $st = $con->prepare("SELECT * FROM books WHERE cat_id = ? And aprove = 1 ");
	  $st->execute(array($catid));
	  $item = $st->fetch(); 
	  $count = $st->rowCount();

	  if ($count > 0) { ?>
<!-- Start Slider Top 10 Downloads -->
<div class="cat">
	<div class="td10">		
		<div class="container-fluid  topdown">
			<div class="owl-carousel">			
				<?php 

					/* Get Books From DB Order by High Downloades */
					$st = $con->prepare("SELECT * FROM books WHERE cat_id = ? And aprove = 1 Order by Downloadconter  DESC LIMIT 7");
					$st->execute(array($catid));
					$items = $st->fetchAll();

					foreach ($items as $book) { ?>
						<?php $catid = $book['cat_id']; ?>
						<!-- Select Category By Id -->
						<?php $st2 = $con->prepare("SELECT * FROM categories WHERE ID = ?");
							  $st2->execute(array($catid));
							  @$rows = $st2->fetchAll();  
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
								<h4><a  href="books.php?id=<?php echo $book['ID']?>&title=<?php echo str_replace(' ', '-', $book['title'])?>"   ><?php echo substr($book['title'],0,40)?></a></h4>
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
										<span class="useravatar"><img class="avatar" src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>"> <?php echo $user['Username']?></span>					
									<?php
								} ?>
							</div>
						</div>							
					        
			        <?php } ?>
				
					
			</div>
		</div>	
	</div>
</div>	
<!-- End Slider Top 10 Downloads -->
<div class="clearfix"></div>
<!-- Start Header With Background Image -->
<div class="container-fluid catpage">
	<div class="row">
		<!-- Side Bar -->
		<div class="sidebar col-sm-3">
			<div class="nav-sidebar">
				<h3><i class="fa fa-rss"></i> Statics </h3>
				<div class="sidebar-content">
					<!-- Get All Books We Have In categories Select by ID -->
					<?php $st4 = $con->prepare("SELECT * FROM books Where cat_id = ? And aprove = 1");
						  $st4->execute(array($catid));
						  $bs = $st4->fetch();
						  $c = $st4->rowCount();?>						  
					<h5><i class="fa fa-book"></i> Books Counter:<span> <?php echo $c; ?></span></h5>

					<!-- Get All Books Downlodes -->
					<?php $st5 = $con->prepare("SELECT * FROM books Where cat_id = ? And aprove = 1");
						  $st5->execute(array($catid));
						  $bos = $st5->fetchAll();
						  $count = 0;
						  foreach ($bos as $bo) { $count = $count + $bo['Downloadconter']; } ?>
					<h5><i class="fa fa-cloud-download"></i> Downolding Counter: <span class="Tootale-download"><?php echo $count; ?></span></h5>
					<h5><i class="fa fa-eye"></i> Visites:<span> +12546</span></h5>
				</div>
			</div>

			<div class="nav-sidebar">				
				<div class="sidebar-content">
					<form action="search.php" method="POST">
						<input type="search" name="areasearch" class="form-control mb-2" placeholder="Put Words,Title,Name & press Enter">
						<button class="btn btn-success btn-block"> <i class="fa fa-search"></i> search</button>
					</form>
				</div>
			</div>

			<div class="nav-sidebar">				
				<div class="sidebar-content">
					<div class="ads">
						Ads
					</div>
				</div>
			</div>
		</div>
		
		<!-- end Side bar -->
		<div class="catbooks col-sm-9">	
			<?php foreach (@$rows as $row) { ?>	
			<div class="books">

				<?php
				$cat = $row['ID'];
				$stmt2 = $con->prepare("SELECT * FROM books WHERE cat_id = ? And aprove = 1 order by ID DESC");
				$stmt2->execute(array($parent));
				$books = $stmt2->fetchAll();				

				foreach ($books as $book) { ?>
									
					<div class="book">
						<img  src="Admin/layout/images/books/<?php echo $book['avatar']?>">
						<span class="Categorey"><?php echo $row['Name']?></span>
						<div class="detail">					
							<h4><a href="books.php?id=<?php echo $book['ID']?>&title=<?php echo str_replace(' ', '-', $book['title'])?>"   > <?php echo substr($book['title'],0,40)?> </a></h4>
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
							<span class="useravatar"><img class="avatar" src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>"> <?php echo $user['Username']?></span>
							<?php } ?>	
						</div>
					</div>												
					
				<?php } ?>				

			</div>	
			<?php } ?>		
		</div>			
	</div>	
</div>
<?php } else { ?>
	<div class="N404">
		<h1>404</h1>
		<SPAN> OoPPS! NO bOoK</SPAN>
	</div>
<?php } ?>
<div class="clearfix"></div>

<!-- end Content Books -->
<?php include $tpl . 'mainfooter.php'; ?>		
<?php include $tpl . 'footer.php'; ?>