<?php session_start(); $pageTitle = 'Search'; include 'init.php'; ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	@$search = strip_tags($_POST['areasearch']);
	@$searchq = preg_replace("#[^0-9a-z]#i", "", $search);
	
	if (!empty($search)) {
		$stmt = $con->prepare("SELECT * FROM books Where title LIKE '%$search%' or tags LIKE '%$search%' ");
		$stmt->execute();
		$books = $stmt->fetchAll();
		
		if (!empty($books)) {
			?>

		<div class="searchcontent container-fluid">
			<div class="catbooks col-sm-12">				
				<div class="books">	
					<h4 class="title"> All Books Related <strong><?php echo @$searchq; ?></strong> </h4>
			<?php
			foreach ($books as $book) {
				?>
			
					<div class="book">
						<img  src="Admin/layout/images/books/<?php echo $book['avatar']?>">
						<?php $catid = $book['cat_id']; ?>
						<!-- Select Category By Id -->
						<?php $st2 = $con->prepare("SELECT * FROM categories WHERE ID = ?");
							  $st2->execute(array($catid));
							  $rows = $st2->fetchAll();  
							  ?>
						<span class="Categorey"><?php foreach ($rows as $row) {
							 echo $row['Name'];
						}?></span>
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
				
				<!-- Pagination -->				
				<div class="Pagination">
					<nav aria-label="Page navigation example">
					  <ul class="pagination justify-content-center">
					    <li class="page-item disabled">
					      <a class="page-link" href="#" tabindex="-1"><i class="fa fa-chevron-left"></i></a>
					    </li>
					    <li class="page-item"><a class="page-link" href="#">1</a></li>
					    <li class="page-item"><a class="page-link" href="#">2</a></li>
					    <li class="page-item"><a class="page-link" href="#">3</a></li>
					    <li class="page-item">
					      <a class="page-link" href="#"><i class="fa fa-chevron-right"></i></a>
					    </li>
					  </ul>
					</nav>
				</div>
				<!-- Pagination -->				

			</div>
			</div>

			<?php 
		} else {
			?><div class="searchcontent">
			<div class="catbooks col-sm-12">				
				<div class="books">	
					<h1 class="l404">:( 404</h1>
					<h4 class="title">Enterd Any <strong>Key Words</strong> Or <strong>Title</strong> To Start Search</h4>
					<div class="header">																			
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
		</div>
		</div><?php
		}

	} else {
		?>
		<div class="searchcontent">
			<div class="catbooks col-sm-12">				
				<div class="books">	
					<h1 class="l404">:( 404</h1>
					<h4 class="title">Enterd Any <strong>Key Words</strong> Or <strong>Title</strong> To Start Search</h4>
					<div class="header">																			
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
		</div>
		</div>
	
		<?php
	}
} ?>
<?php include $tpl . 'mainfooter.php'; ?>	
<?php include $tpl.'footer.php'; ?>