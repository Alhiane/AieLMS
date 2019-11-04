<?php
	
	ob_start();
	

	session_start();
	
	$pageTitle = 'Books';
	
	if (isset($_SESSION['ADname'])) {
	    // session start

	    include 'init.php';

	    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	    if($do == 'Manage'){


	    	$query ='';
            if(isset($_GET['page']) && $_GET['page'] == 'WaitingAproval'){

                $query = 'WHERE aprove = 0';
            }

            if(isset($_GET['page']) && $_GET['page'] == 'Blocked'){

                $query = 'WHERE status = 0';
            }

	    	// Start Manag Page

	    	?>

	    	<div class="container">
				<div class="BookbtnControol">
					<a href="books.php"><button class="btn btn-primary">All</button></a>
					<a href="books.php?do=Manage&page=WaitingAproval"><button class="btn btn-success">Waiting Aproval 
						<?php
			    			$aprove = checkItem("aprove", "books", 0);
			    			if ($aprove > 0) {
			    				echo '<span class="badge badge-danger">' .' '.checkItem("aprove", "books", 0).'</span>';
			    			}			    		
						?>
					</button></a>
					<a href="books.php?do=Manage&page=Blocked"><button class="btn btn-dark">Blocked 
						<?php
			    			$status = checkItem("status", "books", 0);
			    			if ($status > 0) {
			    				echo '<span class="badge badge-danger">' .' '.checkItem("status", "books", 0).'</span>';
			    			}			    		
						?>
					</button></a>					
					<a href="#" class="pull-right"><i class="fa fa-bars"></i></a>
				</div>
				<?php


					$stmt = $con->prepare("SELECT * FROM books $query ORDER BY `books`.`ID` DESC");

			    	$stmt->execute();

			    	$count_books = $stmt->rowCount();

			    	$rows = $stmt->fetchAll();

				?>
				<!-- Show Item Books Grid -->
				<div class="item-books">
					<?php
					if (! Empty($rows)) {
						
					
					foreach ($rows as $row) {						
					echo '<div class="booook grid">';	
						echo '<div class="ManageBook">';
							echo '<div class="books">';
								echo '<div class="book">';
									echo '<div class="thumb">';
										echo "<img src='layout/images/books/". $row['avatar'] ."'>";
									echo "</div>";
									
									echo '<div class="book-detail">';
									$iid = $row['member_id'];
									$stmt4 = $con->prepare("SELECT * FROM users WHERE ID =?");
									$stmt4->execute(array($iid));
									$users = $stmt4->fetchAll();
									foreach ($users as $user) {
										if (!empty($user['Avatar'])) {
											echo "<span class='avatar '><img class='Avatarimage' src='layout/images/avatar/". $user['Avatar'] ."'></span>";
										}else {
											echo "<span class='avatar '><img class='Avatarimage' src='layout/images/avatar/avatar.jpg'></span>";
										}
										echo '<span class="username"><a href="members.php">'.' '. $user["Username"].'</a></span>';
									}
									echo '</div>';	

									echo '<div class="book-body">';
									$cid = $row['cat_id'];
									$stmt5 = $con->prepare("SELECT * FROM categories WHERE ID =?");
									$stmt5->execute(array($cid));
									$cats = $stmt5->fetchAll();
									foreach ($cats as $cat) {
										echo '<div class="book-category"><a href="#">'. $cat['Name'] .'</a></div>';}
										
										echo "<div class='cbtn'>";	
											echo '<a href="books.php?do=Delete&ID='.$row['ID'].'" class="btnC"><button class="btn btn-danger"><i class="fa fa-remove"></i></button></a>';
											echo '<a href="books.php?do=Block&ID='.$row['ID'].'" class="btnC"><button class="btn btn-dark"><i class="fa fa-power-off"></i></button></a>';
											echo '<a href="books.php?do=Edit&ID='.$row['ID'].'" class="btnC"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>';
										echo "</div>";	
										
										echo '<h5 class="book-title" ><a href="books.php?do=Review&ID='.$row['ID'].'" class="title" id="titlelenght" data-text="'. $row['title'] .'">'. substr($row['title'],0,50) .'...</a></h5>';
										echo '<div class="book-description desc" id="desclength" data-text="'. substr($row['description'],0,200) .'">'. substr($row['description'],0,200) .' ...</div>';
															
									echo '</div>';	
							echo '</div>';
							echo '<footer class="book-footer">';
										echo '<span class="fa fa-history"></span> '.$row['date_add'].' ';
										echo '<span class="fa fa-cloud-download "></span>'.' ' .$row['Downloadconter'] . ' Download';
							echo '</footer>';
							?>
							<div <?php if ($row['status'] == 0) {
								echo 'class="blocked"';
							}elseif (($row['aprove'] == 0)) {
								echo 'class="needaprove"';
							}?>>										
								<span><?php if ($row['aprove'] == 0) {
									echo "Waiting Admin Aproval"."</br>" ;
									echo '<a href="books.php?do=Activate&ID='.$row['ID'].'"><button class="btn btn-primary"><i class="fa fa-check-circle"></i></button></a>';
									echo '<a href="books.php?do=Review&ID='.$row['ID'].'"><button class="btn btn-dark"><i class="fa fa-eye"></i></button></a>';
									echo '<a href="books.php?do=Refuse&ID='.$row['ID'].'"><button class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></a>';
							}elseif ($row['status'] == 0) {
									echo "This Book Blocked By Admine". "</br>";
									echo '<a href="books.php?do=Annuleblk&ID='.$row['ID'].'"><button class="btn btn-primary"><i class="fa fa-retweet"></i></button></a>';
									echo '<a href="books.php?do=Review&ID='.$row['ID'].'"><button class="btn btn-dark"><i class="fa fa-eye"></i></button></a>';
									echo '<a href="books.php?do=Delete&ID='.$row['ID'].'"><button class="btn btn-danger"><i class="fa fa-times-circle "></i></button></a>';
								} ?></span>
								
							</div>
							<?php		
												
							echo '</div>';
						echo '</div>';	
					echo '</div>';		

					}
				?> </div>	<!-- Show Item Books Grid -->
				<!-- Show Item Books table -->		
					<table class="table table-sm" style="background: #fff;  display: none;">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Title</th>
					      <th scope="col">Category</th>
					      <th scope="col">Uplod in</th>
					      <th scope="col">Add By</th>
					      <th scope="col">Download time</th>
					    </tr>
					  </thead>
					  <tbody>
					    <?php foreach ($rows as $row) { ?>
					    <tr>
					      <th scope="row"><?php echo $row ['ID']; ?></th>
					      <td><a href="books.php?do=Review&ID=<?php echo $row ['ID']; ?>"><?php echo substr($row ['title'],0,100); ?>...</a></td>
					      <?php $cid = $row['cat_id'];
									$stmt5 = $con->prepare("SELECT * FROM categories WHERE ID =?");
									$stmt5->execute(array($cid));
									$cats = $stmt5->fetchAll(); ?>
					      <?php foreach($cats as $cat) { ?>
					      <td><?php echo $cat['Name']; ?></td>
					  	  <?php } ?>
					      <td><?php echo $row ['date_add']; ?></td>
					      <!-- Get Name user ADD book  -->
					      <?php  ?>
					      <?php foreach($users as $user) { ?>
					      <td><?php echo $user['Username']; ?></td>
					  	  <?php } ?>
					  	  <!-- How Much This Book Download -->
					      <td> <?php echo $row ['Downloadconter']; ?></td>
					    </tr>
					    <?php } ?>

					  </tbody>											  
					</table>
				<!-- Show Item Books table -->		
				 <?php	 

				} else{
					?> 
					<div class="nobook">
						<div class="content">
							<span class="faa"><i class="fa fa-plus"></i> </span>
							<span class="title"><a href="books.php?do=Add"><i class="fa fa-plus"></i> Add New Book</a> </span>
						</div>
					</div>
					<?php
				}
				

				?>			
	    	</div>
	    	<?php


					

	    	// End Manag Page

	    } elseif ($do == 'Add') 	{ 
	    	// Start Page Add New Book
	    		?>
	    		
				<div class="backgroundpage">
	    		<div class="container">
	    			<div class="addnew white card-header bg-primary">
	    			<h5 class="text-center"><i class="fa fa-pencil"></i> Add New Book</h5>
					<form action="?do=Insert" method="POST" enctype="multipart/form-data">
					</div>		
					<div class="newbook card-body bg-light">
						<!-- start Detail Book -->						
						<div class="detail-book ">			
							<!-- start element  title -->
							<div class="titlebook">
								<input type="hidden" name="memberid" placeholder="<?php $_SESSION['ID']?>">
								<input type="text" required="required" id="title" onchane="title()" name="titlebook" class="form-control" placeholder="Choose Unique title to your book (you can't change it after)">
							</div>
							<!-- End element title -->

							<!-- start element description -->
							<div class="descriptionbook">
								
								<div class="form-group">                                            
                                            <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
							</div>
							<!-- End element description -->	
							<!-- start element select categories -->
							<dir class="categoreyselect">
								<div class="father-cat">
									  <select class="custom-select" id="categoriesparent inputGroupSelect01" name="catid"   required="required">
									       	<option value="0" active> Select Cateorey </option>
									       	<?php
								        		$stmt = $con->prepare("SELECT * FROM categories WHERE Parent = 0");
								        		$stmt->execute();
								        		$catsf = $stmt->fetchAll();
								        		foreach ($catsf as $catf) {
								        			
								        			echo "<option id='". $catf['ID'] ."' value='". $catf['ID'] ."'> " . $catf['Name'] . " </option>";								        			
								        		}
								        	?>
									  </select>

								</div>

								<div class="son-cat">
									  <select class="custom-select" name="scatid" id="soncat inputGroupSelect01" >
									    	<?php 

									    	$stmt = $con->prepare("SELECT * FROM users");
											$stmt->execute(array($id));
											$cats = $stmt->fetchAll();
											foreach ($cats as $cat) {
												
												echo "<option value='". $cat['ID'] ."'> " . $cat['Username'] . " </option>";
											}
									    	 ?>
									  </select>
								</div>
							</dir>	
							<!-- End element select categories -->
							<!-- Uplode image Book -->
							<div class="form-control uplodeimage">	
							<span class="fafa"><i class="fa fa-image"></i></span>	
							<span class="text"> Chose Book Image...</span>						
								<input type="file" name="bookAvatar" required="required">				
							</div>
							<!-- End Uplode image Book -->
							<!-- Uplode file Book -->
							<div class="form-control uplodefile">	
							<span class="fafa"><i class="fa fa-file-text-o"></i></span>	
							<span class="text"> Chose Book File(.pdf)...</span>	
								<input type="file" name="bookFile" required="required">
							</div>
							<!-- End Uplode file Book -->
							<!-- start element add tags -->
							<div class="tags">
							    <input type="text" class="form-control" name="tags" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Tgas (Optional)">
							    <small id="emailHelp" class="form-text text-muted">Enter your book tags (tag, tag, ...,).</small>
							</div>			
							<!-- End element add tags -->
						</div>
						<!-- End Detail Book -->
						<div class="submit pull-right">
							<button type="submit" class="btn btn-uplode"><i class="fa fa-cloud-upload"></i> Uplode Book</button>
						</div>
					</div>
					</form>
				</div>
			</div>
				<?php


	    	// End Page Add New Book
		
	    } elseif ($do == 'Insert') 	{
	    	// Start Page Insert To DB
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					// Get Variable From THE FORM
					echo "<div class='container'>";
	    			echo "<div class='insert'>";
					//--// Get Book Image Variable

					$bookAvatarName = strip_tags($_FILES['bookAvatar']['name']);
					$bookAvatarSize = strip_tags($_FILES['bookAvatar']['size']);
					$bookAvatarTmp  = strip_tags($_FILES['bookAvatar']['tmp_name']);
					$bookAvatarType = strip_tags($_FILES['bookAvatar']['type']);

					$avatarAllowedExetention = array("jpg", "jpeg", "png", "gif");

	    			@$avatarExetention = strtolower(end(explode('.', $bookAvatarName))); 	    			

					//--// End Get Book Image Variable

					//--// Get Book FILE Variable

					$bookFileName = strip_tags($_FILES['bookFile']['name']);
					$bookFileSize = strip_tags($_FILES['bookFile']['size']);
					$bookFileTmp  = strip_tags($_FILES['bookFile']['tmp_name']);
					$bookFileType = strip_tags($_FILES['bookFile']['type']);

					$fileAllowedExetention = array("pdf",);

	    			@$fileExetention = end(explode('.', $bookFileName)); 	

					//--// End Get FILE Image Variable	

					// get book detail from the FORM (TITLE, DESCRIPTION, ...)

	    			$booktitle = strip_tags($_POST['titlebook']);
	    			$tags 	   = strip_tags($_POST['tags']);
	    			$bookdesc  = strip_tags($_POST['description']);
	    			$booksize  = ($bookFileSize/1024)/1024;	
	    			$booktype  = $fileExetention;    			
	    			$catfather = strip_tags($_POST['catid']);
	    			$catson    = strip_tags($_POST['scatid']);
	    				    		
					// End book detail from the FORM (TITLE, DESCRIPTION, ...)

					// Form Errors
	    			$formerrors = array();

	    			if (empty($booktitle)){
	    				$formerrors[] = "<div class='alert alert-danger' role='alert'> You Can't less <strong> TITLE </strong> Empty</div>";
	    			}

	    			if (empty($bookdesc)){
	    				$formerrors[] = "<div class='alert alert-danger' role='alert'> You Can't less <strong> DESCRIPTION </strong> Empty</div>";
	    			}

	    			if (empty($catfather)){
	    				$formerrors[] = "<div class='alert alert-danger' role='alert'> You Shoul'd Select <strong> Ctegorey </strong></div>";
	    			}

	    			if (strlen($booktitle) < 8){
	    				$formerrors[] = "<div class='alert alert-danger' role='alert'><strong> TITLE Book </strong> Should be Larger Than 8 Caracters</div>";
	    			}

	    			if (strlen($bookdesc) < 20){
	    				$formerrors[] = "<div class='alert alert-danger' role='alert'><strong> DESCRIPTION Book </strong> Should be Larger Than 20 Caracters</div>";
	    			}

	    			if (!empty($bookAvatarName) && !in_array($avatarExetention, $avatarAllowedExetention)) {
	    				$formerrors[] = "<div class='alert alert-danger'>This Type Is not<strong>Allowed ONLY (.png, .jpg, .jpeg, .gif)</strong></div>";
	    			}

	    			if (empty($bookAvatarName)) {
	    				$formerrors[] = "<div class='alert alert-danger'>Book Image is<strong> Required</strong></div>";
	    			}

	    			if (!empty($bookFileName) && !in_array($fileExetention, $fileAllowedExetention)) {
	    				$formerrors[] = "<div class='alert alert-danger'>This Type Is not<strong> Allowed ONLY (.pdf, .zip, .word)</strong></div>";
	    			}

	    			if (empty($bookFileName)) {
	    				$formerrors[] = "<div class='alert alert-danger'>!!!Book file Is <strong>Required</strong></div>";
	    			}

	    			if ($bookAvatarSize > 10485760) {
	    				$formerrors[] = "<div class='alert alert-danger'>Image Book can't be Large than<strong>4MB</strong></div>";
	    			}

	    			if ($bookFileSize   > 104857600) {
	    				$formerrors[] = "<div class='alert alert-danger'>File Book can't be Large than<strong>30MB</strong></div>";
	    			}

	    			foreach ($formerrors as $error) {
	    				echo $error;
	    			}
	    			// End Form Errors	

	    			// End  Get Variable From THE FORM

	    			// insert to DB	

	    			// Save Form Detail In DB
	    			if(empty($formerrors)){	    			


	    				$filebook 	= rand(0, 10000) . '_' . $bookFileName; 


	    				$avatarbook = rand(0, 10000) . '_' . $bookAvatarName; 	    					    				

	    				// Book File Destination
	    				move_uploaded_file($bookFileTmp, "layout/fileuplodes/book/" . $filebook);
	    				// Book Image(Avatar) Destination
	    				move_uploaded_file($bookAvatarTmp, "layout/images/books/" . $avatarbook);

	    				// Check If not existe same Title in DB
	    				$check = checkItem('title', 'books', $booktitle);
	    				if ($check == 1){
	    				
	    					$theMsg = "<div class='alert alert-danger'> This <strong>Book</strong> Reaaly Exist </div>";
                    		redirectHome($theMsg, 'back', 3);

	    				} else {

	    					$stmt = $con->prepare("
                    			INSERT INTO books(title, description, cat_id, tags, avatar, file, aprove, status, date_add, member_id, size, type) 
                    			VALUES (:ztitle, :zdescription, :zcatid, :ztags, :zavatar, :zfile, 1, 1, now(), :zmember, :zsize, :ztype)");

	    					$stmt->execute(array(

	    						'ztitle' 			=> $booktitle,
	    						'zdescription' 		=> $bookdesc,
	    						'zcatid' 			=> $catfather,	    						
	    						'ztags' 			=> $tags,
	    						'zavatar' 			=> $avatarbook,
	    						'zfile' 			=> $filebook,
	    						'zsize'				=> $booksize,
	    						'ztype'				=> $booktype,
	    						'zmember'			=> $catson
	    									
	    					));

	    					//message Success Insert Detail Book In DB
	    					$theMsg = ' <div class="alert alert-success">'. $stmt->rowCount() .' Record Inserted In Database</div>';
                    		redirectHome($theMsg, 'back', 2);

	    				}


	    			}

					// END insert to DB	
					
				} else{

                	$theMsg = '<div class="alert alert-warning">You Cant Browse This Page </div>';

                }

	    		echo "</div>";
	    		echo "</div>";

	    	// End Page Insert To DB

	    } elseif ($do == 'Edit') 	{
	    	// Start Page Edit Book
	    	
	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$stmt = $con->prepare( "SELECT * FROM books WHERE ID = ? LIMIT 1" );
            $stmt->execute(array($id));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if($stmt->rowCount() > 0) {

	    	
?>
	    		<div class="container">
	    			<div class="addnew white card-header bg-primary">
	    			<h5 class="text-center"><i class="fa fa-pencil"></i> Update Book</h5>
					<form action="?do=Update" method="POST" enctype="multipart/form-data">
					</div>	
					<div class="newbook">
						<!-- start Detail Book -->
						<div class="detail-book ">			
							<!-- start element  title -->
							<div class="titlebook">
								<input type="hidden" name="Id" value="<?php echo $row['ID']?>">
								<input type="text" name="titlebook" class="form-control" placeholder="Choose Unique title to your book (you can't change it after)" value="<?php echo $row['title'];?>">
							</div>
							<!-- End element title -->

							<!-- start element description -->
							<div class="descriptionbook">
								
								<div class="form-group">                                            
                                            <textarea class="form-control" placeholder="<?php echo $row['description'];?>" value="<?php echo $row['description'];?>" name="description" rows="3"></textarea>
                                </div>
							</div>
							<!-- End element description -->	
							<!-- start element select categories -->
							<dir class="categoreyselect">
								<div class="father-cat">
									  <select class="custom-select"  name="catid" id="inputGroupSelect01">
									    <option selected>
									    <?php 
									    $catid = $row['cat_id'];
									    $stmt = $con->prepare('SELECT * FROM categories WHERE ID = ?');
									    $stmt->execute(array($catid));
									    $cats = $stmt->fetchAll();

									    foreach ($cats as $cat ) {
									    	echo $cat['Name'];
									    }									  									    
									    ?>
									    	
									    </option>									  
									  </select>
								</div>

								<div class="son-cat">
									  <select class="custom-select" name="memberid" id="inputGroupSelect01" >
									    	<?php
									    	$usid = $row['member_id'];
								        		$stmt = $con->prepare("SELECT * FROM users WHERE ID = ?");
								        		$stmt->execute(array($usid));
								        		$cats = $stmt->fetchAll();
								        		foreach ($cats as $cat) {
								        			
								        			echo "<option value='". $cat['ID'] ."'> " . $cat['Username'] . " </option>";
								        		}
								        	?>
									  </select>
								</div>
							</dir>	
							<!-- End element select categories -->
							<!-- Uplode image Book -->
							<div class="form-control uplodeimage">
								<i class="fa fa-image cover"></i>
								<div class="custome-uplode-image">
									<span> <i class="fa fa-image"></i> Choose Book Image ...</span>
								<input type="file" name="bookAvatar">
								<input type="hidden" name="oldbookAvatar" value="<?php echo $row['avatar']?>">
									<span class="order">ONELY type : jpg, png,</span>
								</div>
							</div>
							<!-- End Uplode image Book -->
							<!-- Uplode file Book -->
							<div class="form-control uplodefile disabled">
								<i class="fa fa-file-text-o cover"></i>
								<div class="custome-uplode-file">
									<span> <i class="fa fa-file"></i><?php echo $row['file']?></span>
								<input type="file" name="bookFile">
								<input type="hidden" name="oldbookfile" value="<?php echo $row['file']?>">
									<span class="order"><?php echo 'size:' . ' ' .$row['size']. '  ' .'MB'?></span>
								</div>
							</div>
							<!-- End Uplode file Book -->
							<!-- start element add tags -->
							<div class="tags">
							    <input type="text" class="form-control" value="<?php echo $row['tags'];?>" name="tags" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Tgas (Optional)">
							    <small id="emailHelp" class="form-text text-muted">Enter your book tags (tag, tag, ...,).</small>
							</div>			
							<!-- End element add tags -->
						</div>
						<!-- End Detail Book -->
						<dir class="submit pull-right">
							<button type="submit" class="btn btn-uplode"><i class="fa fa-save"></i> save changes</button>
						</dir>
					</div>
					</form>
				</div>
				<?php

			}

	    	
	    	// End Page Edit Book

	    } elseif ($do == 'Update') 	{
	    	// Start Page Update Book

	    	
	    	// End   Page Update Book
	    } elseif ($do == 'Delete') 	{
	    	// Start Page Delet Book
	    	echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'books', $id);

	    	if($Check > 0) {	    
	    		$stmt = $con->prepare( "DELETE FROM books WHERE ID = :zid" );
                $stmt->bindParam(":zid", $id);
                $stmt->execute();

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record DELETED In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg, 'home', 2);
                        
               }

               echo "</div>";
    			echo "</div>";
	    	// End Page Delet Book

	    } elseif ($do == 'Activate') 	{
	    	// Start Page Activate Book
	    	echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'books', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "UPDATE books SET aprove = 1 WHERE ID = ?" );
                
                $stmt->execute(array($id));

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record UPDATE In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg, 'home', 2);
                        
               }

               echo "</div>";
    			echo "</div>";

	    	// End Page Activate Book

	    } elseif ($do == 'Review') 	{
	    	// Start Page Review Book
	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$stmt = $con->prepare( "SELECT * FROM books WHERE ID = ? LIMIT 1" );
            $stmt->execute(array($id));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if($stmt->rowCount() > 0){

            	?>      

            	<div class="reviewbook">
					<div class="header">											
						<div class="overlay">											
							<div class="container">		
								<div class="title">
									<h3><?php echo $row['title'] ?></h3>
								</div>

								<div class="listdestail">
									<ul>
										<li><span>Title :</span><?php echo " ".$row['title'] ?></li>
									</ul>

									<ul>
										<?php										
										$cid = $row['cat_id'];
										$stmt = $con->prepare("SELECT * FROM categories WHERE ID =?");
										$stmt->execute(array($cid));
										$cats = $stmt->fetchAll();
										foreach ($cats as $cat) {
										echo "<li><span>Category:</span>"." ".$cat['Name']."</li>";
										}
										?>										
									</ul>

									<ul  class="semi">
										<li class="size" id="sizelength" data-text='<?php echo $row['size'] ?>' ><span >Size:</span ><?php echo " ".substr($row['size'],0,4) ?> MB</li>
									</ul>

									<ul class="semi nopd">
										<li><span >Type:</span><?php echo " .".$row['type'] ?></li>
									</ul>

									<ul>
										<li><span class="small">Download Time:</span><?php echo " ".$row['Downloadconter'] .' Download'?></li>
									</ul>

									<ul class="semi ">
										<li><span >Type:</span> .pdf</li>
									</ul>

									<ul class="semi ">
										<li><span ><i class="fa fa-history"></i><?php echo ' '. $row['date_add'] ?></span></li>
									</ul>
									<ul>
										<?php
										
										$iid = $row['member_id'];
										$stmt4 = $con->prepare("SELECT * FROM users WHERE ID =?");
										$stmt4->execute(array($iid));
										$users = $stmt4->fetchAll();
										foreach ($users as $user) {
										echo "<li><span>Add By:</span>".' '.$user['Username']."</li>";
										}
										?>											
									</ul>
								</div>

								<div class="description">
									<p><?php  echo $row['description']?></p>
								</div>

								<div class="image">
									<?php
									echo "<img src='layout/images/books/". $row['avatar'] ."'>";
									?>
								</div>
								<?php
								$tags = $row['tags'];
								$tag = explode(",", $tags);
								echo "<div class='tags'>";
								foreach ($tag as $tt => $tagss) {								
									echo'<span class="small">'.$tagss.'</span>';								
								}
								echo "</div>";
								?>								
							</div>
						</div>		
					</div>
					
					<div class="udr container">
						<?php if ($row['aprove'] == 0 ): ?>
							<a href="books.php?do=Activate&ID=<?php echo $row['ID']?>"><button class="btn btn-primary"><i class="fa fa-check"></i> Aprove</button></a>
						<?php endif ?>

						<?php if ($row['aprove'] == 0 ): ?>
							<a href="books.php?do=Refuse&ID=<?php echo $row['ID']?>"><button class="btn btn-warning"><i class="fa fa-ban"></i> Refuse</button></a>
						<?php endif ?>
						
						<a href="books.php?do=Delete&ID=<?php echo $row['ID']?>"><button class="btn btn-danger dm"><i class="fa fa-remove"></i> Delete</button></a>
						<?php if ($row['status'] == 1): ?>
							<a href="books.php?do=Block&ID=<?php echo $row['ID']?>"><button class="btn btn-dark dm"><i class="fa fa-power-off"></i> Block</button></a>
						<?php endif ?>

						<?php if ($row['status'] == 0): ?>
							<a href="books.php?do=Annuleblk&ID=<?php echo $row['ID']?>"><button class="btn btn-dark dm"><i class="fa fa-check-square-o "></i> Annule Block</button></a>
						<?php endif ?>
					</div>

				</div>					
				<?php				
            } else {
            	$theMsg = '<div class="alert alert-danger">There Is No Such Id</div>';
				redirectHome($theMsg, 'home', 2);
            }
	    	// End Page Review Book
	    }elseif ($do == 'read') {
	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'books', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "SELECT * FROM books WHERE ID = ?" );
                
                $stmt->execute(array($id));

                $rows = $stmt->fetchAll();

                foreach ($rows as $row) {
                	$file= $row['file'];
                	header('Content-type: application/pdf');
                	header('Content-Disposition: inline; filename="'. $file .'"');
                	header('Content-Transfer-Encoding: binary');
                	header('Accept-Ranges: bytes');
                	@readfile($file);
                	/*
                	header("Content-Length: " . filesize ('theme/assets/pdf/ci.pdf' ) ); 
					header("Content-type: application/pdf"); 
					header("Content-disposition: attachment;     
					filename=".basename('theme/assets/pdf/ci.pdf'));
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					$filepath = readfile('theme/assets/pdf/ci.pdf');*/
                }
				

	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg, 'home', 2);
                        
               }

	    } elseif ($do == 'Download') {
	    	

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'books', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "SELECT * FROM books WHERE ID = ?" );
                
                $stmt->execute(array($id));

                $rows = $stmt->fetchAll();

                foreach ($rows as $row) {
                	$d = $row['Downloadconter'] + 1;
                	$download = $d++;
                	$stmt44 = $con->prepare( "UPDATE books SET Downloadconter = ? WHERE ID = ?" );
                	$stmt44->execute(array($download,$id));
                	$query_count = mysqli_query($con,$stmt44);

                	$file= $row['file'];
                	header('Content-type: application/pdf');
                	header('Content-Disposition: inline; filename="'. $file .'"');
                	header('Content-Transfer-Encoding: binary');
                	header('Accept-Ranges: bytes');
                	@readfile($file);               
                }
				
				

	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg,'home', 2);
                        
               }

	    } elseif ($do == 'Block') {
	    	echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'books', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "UPDATE books SET status = 0 WHERE ID = ?" );
                
                $stmt->execute(array($id));

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record UPDATE In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg, 'home', 2);
                        
               }

               echo "</div>";
    			echo "</div>";	
	    }elseif ($do == 'Annuleblk') {
	    	echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'books', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "UPDATE books SET status = 1 WHERE ID = ?" );
                
                $stmt->execute(array($id));

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record UPDATE In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg, 'home', 2);
                        
               }

               echo "</div>";
    			echo "</div>";	
	    }

	    include $tpl . 'footer.php';

	    // session end
	} else {

		header('Location: login.php');

    	exit();
	}    

	ob_end_flush();

?>