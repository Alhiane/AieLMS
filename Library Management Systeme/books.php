<?php 
session_start();
$noNavbar = "";
@$pageTitle = str_replace('-',' ',$_GET['title']);
@$catid = $_GET['id'];

include 'init.php';
?>

<?php $id = (isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 );
	    	$stmt = $con->prepare( "SELECT * FROM books WHERE ID = ? AND aprove = 1 LIMIT 1" );
            $stmt->execute(array($id));
            $books = $stmt->fetchAll();            

            foreach ($books as $book) { ?>             	
            <!-- Strat Books loop -->
	            <div class="container">
	            	<div class="row boook">
	            		<div class="col-md-3 avatar" style="height: 370px; padding: 0;">
	            			<img src="Admin/layout/images/books/<?php echo $book['avatar']?>" style="width: 100%; height: 100%;">
	            			<span class="down"> <i class="fa fa-cloud-download"></i> 
	            				<?php echo $book['Downloadconter'] ?>
	            			</span>
	            		</div>
	            		<div class="col-md-6 title" style="padding: 8px">
	            			<h3 class="float-left mb-3"><?php echo $book['title']; ?></h3>
	            			<div class="clearfix"></div>
	            			<p><?php echo $book['description']; ?></p>
	            		</div>
	            		<div class="col-md-3 info" style="background-color: #eee; padding: 0">
	            			<ul>	            				
	            				<li><span><i class="fa fa-tag"></i> Category : </span> <?php $category = $book['cat_id'];
	            						  $st = $con->prepare("SELECT * FROM categories WHERE ID=? limit 1"); 
	            						  $st->execute(array($category)); 
	            						  $cats = $st->fetchAll(); 
	            						  foreach($cats as $cat){ ?>
	            						  	<a href="categories.php?id=<?php echo $cat['ID']?>&pagename=<?php echo str_replace(' ', '-', $cat['Name'])?>"> <?php echo $cat['Name']; ?> </a>
	            						  <?php } ?>	            						  	
    						    </li>

    						    <li><span><i class="fa fa-language"></i> Language : </span> <?php echo $book['lang'] ?></li>
    						    <li><span><i class="fa fa-pencil-square"></i> Autour : </span> <?php echo $book['author'] ?></li>
    						    <li><span><i class="fa fa-tint"></i> Size : </span> <?php $siz = ($book['size'] / 1024) / 1024; echo substr($siz, 0,4); ?> MB</li>
    						    <li><span><i class="fa fa-file-text"></i> type : </span> .<?php echo $book['type']; ?></li>
    						    <li><span><i class="fa fa-copy"></i> Pages : </span><?php echo $book['pages'] ?> </li>
    						    <li><span><i class="fa fa-clock-o"></i> Add In : </span> <?php echo $book['date_add']; ?></li>
    						    <!-- Get Tags And prepared it -->
    						    <?php $tags = $book['tags']; ?>
								<?php $tag = explode(',', $tags); ?>
								<?php if (!empty($tags)) {?>
    						    <li><span><i class="fa fa-tags"></i> Tags : </span> 
    						    	<?php foreach ($tag as $tt => $tagss) {
								  	echo "<a>" . substr($tagss,0,20)." . "."</a>";
																		  } ?>

    						    </li>
    						    <?php } ?>
    						    <div class="clearfix"></div>
    						    <!-- Get user add book information -->
    						    <?php $userid = $book['member_id']; ?>
								<?php $st = $con->prepare("SELECT * FROM users WHERE ID = ?"); 
	            						  $st->execute(array($userid)); 
	            						  $users = $st->fetchAll(); 
	            						  foreach($users as $user){ ?>

    						    <li class="user"><span class="avatar">
    						    <?php if(!empty($user['Avatar'])) { ?>	
    						    	<img src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>" class="avatar">
						    	<?php }else{ ?>
						    		<img src="Admin/layout/images/avatar/avatar.jpg" class="avatar">
						    	<?php } ?>
    						    </span> <?php echo $user['Username']?> </li>
    							<?php } ?>
	            			</ul>
	            		</div>
	            	</div>

	            	<div class="clearfix"></div>

	            	<div class="book-btn">
	            		<div class="row">
	            			<div class="col-9 ads">
	            				ADS
	            			</div>

	            			<!-- btn Download & read -->

	            			<div class="col-3 btns">
	            				<a href="download.php?book_id=<?php echo $book['ID']?>"><button class="btn btn-success"><i class="fa fa-cloud-download"></i> Download </button></a>
	            				<a href="read.php?book_id=<?php echo $book['ID']?>"><button class="btn btn-primary"> <i class="fa fa-play"></i> Read </button></a>
	            			</div>        			
	            		</div>
	            	</div>

	            	
	            </div>

	            <!-- Start Slider Top 10 Downloads -->
	            <div class="on-same-category">
					<div class="td10">
						<h3 class="topdown10 text-center"><i class="fa fa-tag"></i> On Same Category</h3>
						<div class="container  topdown">
							<div class="owl-carousel">			
								<?php 

									/* Get Books From DB Order by High Downloades */
									$st = $con->prepare("SELECT * FROM books WHERE cat_id = ? And aprove = 1 Order by ID  DESC  LIMIT 7");
									$st->execute(array($category));
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
														<?php if(!empty($user['Avatar'])) { ?>	
															<img class="avatar" src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>">
														<?php }else{ ?>
															<img class="avatar" src="Admin/layout/images/avatar/avatar.jpg">	
														<?php } ?>
															<?php echo $user['Username'] ?>
														</span>					
													<?php
												} ?>
											</div>
										</div>							
									        
							        <?php } ?>				
							</div>
						</div>	
					</div>

					<!-- End Slider Top 10 Downloads -->           
            <!-- END Books loop -->
             <?php } ?>
<?php include $tpl . 'mainfooter.php'; ?>	
<?php include $tpl . 'footer.php'; ?>