<?php $pageTitle = 'Dash' ?>


<?php 
	ob_start();
		session_start();								
			if (isset($_SESSION['user_session'])) {
			    include 'init.php';

			    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

			    if($do == 'Manage'){ 
			    	$usid = $_SESSION['id_session'];			    	
			    	$stmt = $con->prepare('SELECT * FROM users Where ID = ?');
			    	$stmt->execute(array($usid));
			    	$rows = $stmt->fetchAll();
			    	?>
			    	<!-- Page Manage Dashborde -->
			    	<div class="container">
			    		<div class="row dash">
						  <div class="col-12 col-md-12 col-md-4 col-lg-4" style="margin-bottom: 5px"><!-- Start Tab List -->
						    <div class="list-group" id="list-tab" role="tablist">
						    	<!-- Home -->
						      <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home"><i class="fa fa-desktop"></i> Home</a>
						      	<!-- Profile -->
						      <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile"><i class="fa fa-user"></i> Profile</a>
						      	<!-- Stattics -->
						      <a class="list-group-item list-group-item-action" id="list-statics-list" data-toggle="list" href="#list-statics" role="tab" aria-controls="statics"><i class="fa fa-bar-chart-o "></i> Statics</a>
						      	<!-- Uplode New Book -->
						      <a class="list-group-item list-group-item-action  text-center" id="list-uplode-list" data-toggle="list" href="#list-uplode" role="tab" aria-controls="uplode"><i class="fa fa-cloud-upload"></i></a>
						    </div>
						  </div><!-- End Tab List -->
						  <div class="col-12 col-md-12 col-lg-8 content"><!-- Start Tab Content -->
						    <div class="tab-content" id="nav-tabContent">
						    	<!-- Home List Content -->
						      <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
						      	<!-- Home content -->
						      	<div class="home-info text-center"><h4><i class="fa fa-th-large"></i> Dashbord</h4></div>
						      	<?php $id = $_SESSION['id_session'];
						      		  $stmt = $con->prepare("SELECT * FROM books WHERE member_id = ?");
						      		  $stmt->execute(array($id));
						      		  $books = $stmt->fetch();
						      		  $count1 = $stmt->rowCount(); ?>
						      	<div class="nots">
						      		<div class="not"><i class="fa fa-book"></i>All books : <?php echo $count1 ?></div>
						      		<div class="not"><i class="fa fa-cloud-download"></i>Total Downloades : <span class="not2"></span></div>
						      	<?php $stmt = $con->prepare("SELECT * FROM books WHERE member_id = ? And aprove = 0");
						      		  $stmt->execute(array($id));
						      		  $books = $stmt->fetch();
						      		  $count2 = $stmt->rowCount(); ?>
						      		<div class="not"><i class="fa fa-check"></i>Waiting AP : <?php echo $count2 ?></div>
						      	</div>						      							      	
						      	
						      	<div class="nots">
						      	<?php if ($count2 > 0) { ?>
						      		<div class="notification aprove"><i class="fa fa-bell"></i> You Have <?php echo $count2  .' ( '. substr($books['title'],0,10).' ) '  ?> Book Waiting Admin Aprovale </div>
						      	<?php } ?>	

						      	<?php $stmt = $con->prepare("SELECT * FROM books WHERE member_id = ? And status = 0");
						      		  $stmt->execute(array($id));
						      		  $books = $stmt->fetch();
						      		  $count3 = $stmt->rowCount(); ?>

						      	<?php if ($count3 > 0) { ?>	  
						      		<div class="notification blocked"><i class="fa fa-bell"></i> You Have <?php echo $count3 .' ( '. substr($books['title'],0,10).' ) ' ?> Book Blocked by Admin Checked Statics Table </div>
						        <?php } ?>
						      	</div>
						      	
						      	<div class="nots">
						      		<div class="notification" style="margin-bottom: -1px;"><i class="fa fa-book"></i> Last static 5 books </div>
						      		<!-- Start Get The books Detail from DB -->
											<?php $id = $_SESSION['id_session'];
												  $stmt = $con->prepare("SELECT * FROM books Where member_id = ? LIMIT 5");
												  $stmt->execute(array($id));
												  $books = $stmt->fetchAll();
												   ?>

											<table class="table table-sm">
											  <thead>
											    <tr>
											      <th scope="col">#</th>
											      <th scope="col">Title</th>
											      <th scope="col">Uplod in</th>
											      <th scope="col">Download time</th>
											    </tr>
											  </thead>
											  <tbody>
											    <?php foreach ($books as $book) { ?>
											    <tr>
											      <th scope="row"><?php echo $book ['ID']; ?></th>
											      <td><a href="dashbord.php?do=EditBook&id=<?php echo $book ['ID']; ?>"><?php echo substr($book ['title'],0,100); ?>...</a></td>
											      <td><?php echo $book ['date_add']; ?></td>
											      <td> <?php echo $book ['Downloadconter']; ?></td>
											    </tr>
											    <?php } ?>

											  </tbody>											  
											</table>
						      	</div>
						      	<!-- End Home Content -->
						      </div>
						      	<!-- Profile List Content -->
						      <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
						      	<div class="user-info">
						      		<?php foreach ($rows as $user) { ?>
						      		<?php if(!empty($user['Avatar'])) { ?>	
						      			<img src="Admin/layout/images/avatar/<?php echo $user['Avatar']?>" class="img-thumbnail" style="width: 100px; height: 100px;">
						      		<?php }else{ ?>
						      			<img src="Admin/layout/images/avatar/avatar.jpg" class="img-thumbnail" style="width: 100px; height: 100px;">
						      		<?php } ?>
						      		<div class="name"><?php echo $user['Fullname'] ?></div>
						      		<div class="email"><?php echo $user['Email'] ?></div>
						      		<div class="date">Joined In : <?php echo $user['Date_Add'] ?></div>
						      		<span><i class="fa fa-edit"></i></span>
						      	    <?php } ?>
						      	</div>
						      	<!-- User Uplodes -->
						      	<div class="user-uplodes">
						      		<?php $st1 = $con->prepare('SELECT * from books where member_id = ?');
						      				  $st1->execute(array($usid));
						      				  $books = $st1->fetchAll();
						      				  foreach ($books as $book) { ?>	
						      		<div class="item">
						      			<img class="item-img" src="Admin/layout/images/books/<?php echo $book['avatar'];?>">
						      			<span class="up"><i class="fa fa-cloud-download"></i><p class="counter"><?php echo $book['Downloadconter']; ?></p></span>						      							      			
						      		</div>
						      			<?php } ?>						      		

						      	</div>
						      	<!-- End User Uplodes -->
						      	<!-- Edit User Information Account -->
						      	<?php $st2 = $con->prepare("SELECT * FROM users WHERE ID = ?");
						      		  $st2->execute(array($usid));
						      		  $row = $st2->fetch();
						      		  $count = $st2->rowCount();
						      		  if ($count > 0 ) { ?>
						      	<div class="edit-info">
						      		<form action="?do=Update" method="POST" enctype="multipart/form-data">						      			
						      			<input type="hidden" name="req" value="up-user">						      				
						      			<label><i class="fa fa-slack"></i> Username (Can't Changed)</label>					
						      				<input type="" name="user" class="form-control col-4 mb-3" disabled="" value="<?php echo $row['Username']?>">						      			
						      			<label class="<?php if(empty($row['Fullname'])) { echo 'red'; } ?>" ><i class="fa fa-user"></i> First Name & Last Name</label>						      			
						      				<input type="" name="fullname" class="form-control col-4 mb-2" value="<?php echo $row['Fullname']?>">
						      			<label class="<?php if(empty($row['Email'])) { echo 'red'; } ?>" ><i class="fa fa-envelope-square"></i> Email</label>
						      				<input type="email" name="email" class="form-control col-4 mb-3" value="<?php echo $row['Email']?>">			   
						      				<input type="hidden" name="oldpass" class="form-control col-4 mb-3" value="<?php echo $row['Password']?>">
						      			<label><i class="fa fa-key"></i> New Password</label>
						      				<input type="password" name="newpass" class="form-control col-4 mb-3">
						      			<label class="<?php if(empty($row['Avatar'])) { echo 'red'; } ?>" ><i class="fa fa-photo"></i> Account Avatar</label>
						      				<input type="hidden" name="oldavatar" value="<?php echo $row['Avatar']?>">
						      				<input type="file" name="avatar" class="form-control col-4 mb-3" value="<?php echo $row['Avatar']?>">	
						      			<button class="btn btn-success btn-block col-4 mb-3">Save</button>			
						      		</form>
						      	</div>
						      <?php } ?>
						      	<!-- End Edit User Information Account -->
						      </div>
						      	<!-- Statics List Content -->
						      <div class="tab-pane fade" id="list-statics" role="tabpanel" aria-labelledby="list-statics-list">
						      	<!-- Statics -->
						      		<div><h4><i class="fa fa-bar-chart-o"></i> Your Books Statics</h4></div>
						      		<div class="table-static" style="margin-top: -8px; padding:5px;">
										<div class="table-responsive">

											<!-- Start Get The books Detail from DB -->
											<?php $id = $_SESSION['id_session'];																	  
												  $stmt = $con->prepare("SELECT * FROM books Where member_id = ?");
												  $stmt->execute(array($id));
												  $books = $stmt->fetchAll();
												   ?>

											<table class="table table-sm" style="background: #2229;">
											  <thead>
											    <tr>
											      <th scope="col">#</th>
											      <th scope="col">Title</th>
											      <th scope="col">Uplod in</th>
											      <th scope="col">Download time</th>
											      <th scope="col">Views time</th>
											      <th scope="col">Status</th>
											    </tr>
											  </thead>
											  <tbody>
											    <?php foreach ($books as $book) { ?>
											    <tr>
											      <th scope="row"><?php echo $book ['ID']; ?></th>
											      <td><a href="dashbord.php?do=EditBook&id=<?php echo $book ['ID']; ?>"><?php echo substr($book ['title'],0,40); ?>...</a></td>
											      <td><?php echo $book ['date_add']; ?></td>
											      <td> <?php echo $book ['Downloadconter']; ?></td>
											      <td> +222003</td>
											      <td>											      
											      
											      <?php if ($book['status'] == 0) {?>
											      
											      	<span class="blocked">blocked</span>
											      
											      <?php }else{ ?>
											      
											      	<?php if($book['aprove'] == 1){ ?>
											      		<span class="publish">publishid</span>
											      	<?php }else{ ?>
											      		<span class="waiting">waiting AP</span>
											      	<?php } ?>
											      
											      <?php } ?>
											      
											      </td>
											    </tr>
											    <?php } ?>

											  </tbody>											  
											</table>											
										</div>
						      		</div>
								<!-- List Statics -->						      	
						      </div>
						      	<!-- Uplodes List Content -->
						      <div class="tab-pane fade" id="list-uplode" role="tabpanel" aria-labelledby="list-uplode-list">
						      	<!-- Start Filed Uplode Books To Data Base  -->
						      		<div class="info"><h4> <i class="fa fa-cloud-upload"></i> Uplode New Book</h4></div>
						      		<div class="uplode-form" style="padding: 5px;">
						      				<!-- Start Form Book Up -->
						      			<form action="?do=Insert" method="POST" enctype="multipart/form-data">
						      				<!---->
											<input type="hidden" name="req" value="up-book">						      				
						      				<label>Book Title <span style="color: #e94d16; font-weight: 600">(Choose A uique Title we Don't Accepte Books Isset Before)</span> </label>
						      				<input type="text" name="title" id="title" class="form-control col-8 mb-3" placeholder="Choose A uique Title we Don't Accepte Books Isset Before" autocomplete="off">
						      				<!---->
						      				<label>Get a Short Description</label>
						      				<textarea name="desc" id="desc" class="form-control col-8 mb-3" style="color: #228" autocomplete="off"></textarea>
						      				<!---->
											<select class="custom-select form-control col-4 mb-3" name="lang" style="display: inline-block;">
											  <option selected>Select Books Languge</option>
											  <option value="Arabic">Arabic</option>
											  <option value="French">French</option>
											  <option value="English">English</option>
											  <option value="Spanish">Spanish</option>
											  <option value="China">China</option>
											  <option value="Turkish">Turkish</option>
											  <option value="Italy">Italy</option>
											  <option value="latine">latine</option>
											</select>						      				
						      				<!---->
						      				
						      				<!---->
						      				<select class="custom-select form-control col-4 mb-3" name="cat" style="display: inline-block;">
											  <option selected>Select The Category</option>											  
											  <?php $stmt = $con->prepare("SELECT * FROM categories Where Parent = 0");
											        $stmt->execute();
											        $cats = $stmt->fetchAll();
											        foreach($cats as $cat) { ?>
											        	<option value="<?php echo $cat['ID']?>"><?php echo $cat['Name']?></option>
											        <?php } ?>
											</select>
						      				<!---->
						      				<div class="clearfix"></div>
						      				<!---->
						      				<div class="custome-up mb-3">
						      					<span><i class="fa fa-image"></i></span>
						      					<input type="file" name="avatarbook">
						      				</div>
						      				<!---->
						      				<div class="clearfix"></div>
						      				<!---->
						      				<label style="display: inline-block;"><i class="fa fa-user" style="display: block;"></i> Author</label>
						      				<input type="text" name="author" id="author" class="form-control col-3 mb-3" placeholder="Book Author" style="display: inline-block;">						      			
						      				<!---->
						      				<label style="display: inline-block;"><i class="fa fa-file" style="display: block;"></i> Number Pages</label>
						      				<input type="text" name="pages" id="pages" class="form-control col-2 mb-3" placeholder="120 page (..)" style="display: inline-block;">	
						      				<!---->
						      				<div class="custome-up mb-3">
						      					<span><i class="fa fa-file"></i></span>
						      					<input type="file" name="filebook">
						      				</div>
						      				<!---->	
						      				<label><i class="fa fa-tags"></i> Tgas (Optional)</label>
						      				<input type="text" name="tags" class="form-control col-8 mb-3" placeholder="galilou,Prince,....,...,">
						      				<!---->	
						      				<button class="btn btn-success"><i class="fa fa-cloud-upload"></i> Insert </button>				      				
						      			</form> <!-- end Form Book Up -->
						      		</div>
						      	<!-- END Filed Uplode Books To Data Base  -->
						      </div>
						    </div>
						 </div><!-- End Tab Content -->
					  </div>
		    	   </div>
			    	   <!-- End Page Manage Dashborde -->

			    <?php } elseif($do == 'Update'){
	    		
	    		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			    	
			    	$req = $_POST['req'];	
			    	
			    	if ($req == 'up-user') {	
			    	/* Statrt User Update */		    	
			    	echo "<div class='container'>";	 
			    	echo "<div class='update'>";	    		

			    	// get Avatar img Detail
	    			$avatarName 	= strip_tags($_FILES['avatar']['name']);
	    			$avatarSize 	= strip_tags($_FILES['avatar']['size']);
	    			$avatarTmp	 	= strip_tags($_FILES['avatar']['tmp_name']);
	    			$avatarType 	= strip_tags($_FILES['avatar']['type']);

	    			// Allowed file type 

	    			$avatarAllowedExetention = array("jpg", "jpeg", "png", "gif");

	    			@$avatarExetention =strtolower(end(explode('.', $avatarName))); 

	    			@$id 	  = $_SESSION['id_session'];	    				    			
	    			@$fullname = strip_tags($_POST['fullname']);	    				    			
	    			@$email 	  = strip_tags($_POST['email']);
	    			
	    			// Get Password value
	    			$password = empty($_POST['newPassword']) ? $_POST['oldpass'] : sha1($_POST['newpass']);

	    			//errors
	    			@$formerrors = array();

	    			if(strlen($fullname) < 5 ){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Than 5 caracteres </div>";
	    			}
	    			
	    			if(strlen($fullname) > 40){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Hight then 20 caracteres </div>";
	    			}

	    			if(empty($fullname)){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Empty</div>";
	    			}


	    			if(strlen($password) < 6){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Password </strong>Then 6 Caracteres</div>";
	    			}

	    			if(empty($email)){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Email </strong>Empty</div>";
	    			}

	    			 foreach ($formerrors as $error) {
                        echo $error;
                    }

                    if(empty($formerrors)) {
                    	
                    	

                    	if(empty($avatarName)){
                    		@$avatar = $_POST['oldavatar'];
                    	
                    	}else {
                    		@$avatar = rand(0, 1000000) . '_' . $avatarName;
                    	}
                    	move_uploaded_file($avatarTmp, "Admin/layout/images/avatar/" . $avatar);

                    	// Update Information user in To DB

                    	@$stmt = $con->prepare("UPDATE users SET Fullname = ?, Email = ?, Password = ?, Avatar = ? WHERE ID = ?");
                    	@$stmt->execute(array($fullname, $email, $password, $avatar, $id));

                    	// Message success UPDATE

                    	@$theMsg= ' <div class="alert alert-success"> '. $stmt->rowCount() . ' Record Update</div>';
                        redirectHome($theMsg, '', 3);
                    }
                    echo "</div>";
                    echo "</div>";
			    	/* End User Update */ 
			    	}elseif ($req == "upbook") {			    	
			    		/* Update Book Information*/
			    	echo "<div class='container'>";	 
			    	echo "<div class='update'>";	    					    	
			    	// get Avatar img Detail
	    			$avatarName 	= strip_tags($_FILES['avatar']['name']);
	    			$avatarSize 	= strip_tags($_FILES['avatar']['size']);
	    			$avatarTmp	 	= strip_tags($_FILES['avatar']['tmp_name']);
	    			$avatarType 	= strip_tags($_FILES['avatar']['type']);

	    			// Allowed file type 

	    			$avatarAllowedExetention = array("jpg", "jpeg", "png", "gif");

	    			@$avatarExetention =strtolower(end(explode('.', $avatarName))); 
	    			 
	    			@$id = $_POST['id'];   				    			
	    			@$desc = empty($_POST['newdesc']) ? $_POST['olddesc'] : strip_tags($_POST['newdesc']);
	    			@$author = empty($_POST['author']) ? $_POST['oldauthor'] : strip_tags($_POST['author']);
	    			@$lang = strip_tags($_POST['lang']);
	    			@$pages = strip_tags($_POST['pages']);	    			

	    			//errors
	    			@$formerrors = array();

	    			if(strlen($desc) < 5 ){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Description </strong>Than 5 caracteres </div>";
	    			}
	    			
	    			if(strlen($desc) < 40){
	    				$formerrors[] = "<div class='alert alert-danger'> should Less<strong> Description </strong>more then 40 caracteres </div>";
	    			}

	    			 foreach ($formerrors as $error) {
                        echo $error;
                    }

                    if(empty($formerrors)) {
                    	
                    	

                    	if(empty($avatarName)){
                    		@$avatar = $_POST['oldavatar'];
                    	
                    	}else {
                    		@$avatar = rand(0, 1000000) . '_' . $avatarName;
                    	}
                    	move_uploaded_file($avatarTmp, "Admin/layout/images/books/" . $avatar);

                    	// Update Information user in To DB

                    	@$stmt = $con->prepare("UPDATE books SET description = ?, lang = ?, author = ?, pages = ?, avatar = ? WHERE ID = ?");
                    	@$stmt->execute(array($desc, $lang, $author, $pages, $avatar, $id));

                    	// Message success UPDATE

                    	@$theMsg= ' <div class="alert alert-success"> '. $stmt->rowCount() . ' Record Update</div>';
                        redirectHome($theMsg, 'back', 3);
                    }
                    echo "</div>";
                    echo "</div>";
			    		/* Update Book Information*/
						}

			    }
			    // End page Update
			    }elseif($do == 'Insert'){
			    	// start page insert book detail to dataB
			    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			    		
			    		// get user id from session
			    		$id = $_SESSION['id_session'];

			    		// get book avatar detail
			    		$avatarName = $_FILES['avatarbook']['name'];
			    		$avatarSize = $_FILES['avatarbook']['size'];
			    		$avatartmp = $_FILES['avatarbook']['tmp_name'];
			    		$avatarType = $_FILES['avatarbook']['type'];

			    		// Extention Allowed To Use
			    		$avAllowedExetention = array("jpg", "jpeg", "png", "gif");
	    				@$avExetention =strtolower(end(explode('.', $avatarName)));
			    		// get book  file  detail
			    		$fileN = $_FILES['filebook']['name'];
			    		$fileS = $_FILES['filebook']['size'];
			    		$fileP = $_FILES['filebook']['tmp_name'];
			    		$fileT = $_FILES['filebook']['type'];

			    		// Extention Allowed To Use
			    		$fileAllowedExetention = array("pdf", "zip");
	    				@$fileExetention =strtolower(end(explode('.', $fileN)));
			    		
			    		// Get Other value title desc ... 
			    		@$title 	= $_POST['title'];
			    		@$desc 		= $_POST['desc'];
			    		@$lang 		= $_POST['lang'];
			    		@$cat 		= $_POST['cat'];
			    		@$author 	= $_POST['author'];
			    		@$pages 	= $_POST['pages'];

			    		// Get And proccess Tags
			    		@$tags = $_POST['tags'];

			    		if (!empty($tags)) {
			    			$tag = $_POST['tags'];
			    		}else{
			    			$tag = '';
			    		}

			    		// form Errors to check All field 

			    		@$formerrors = array();

			    			if(strlen($title) < 5 ){
			    				$formerrors[] = "<div class='alert alert-danger'><strong> Title </strong> Must be Than 5 Caracteres</div>";
			    			}

			    			if(strlen($desc) < 50 ){
			    				$formerrors[] = "<div class='alert alert-danger'><strong> Description </strong> Must be Than 50 Caracteres</div>";
			    			}
			    			

			    			if (!in_array($fileExetention, $fileAllowedExetention)) {
			    				$formerrors[] = "<div class='alert alert-danger'>This Type Is not<strong>Allowed ONLY (.pdf, .zip)</strong></div>";
			    			}

			    			if(empty($lang)){
			    				$formerrors[] = "<div class='alert alert-danger'>Should Choose Book<strong> Languge </strong></div>";
			    			}

			    			if(empty($cat)){
			    				$formerrors[] = "<div class='alert alert-danger'>The book Not Publishid If you Dont Select <strong> Category </strong></div>";
			    			}

			    			if(empty($author)){
			    				$formerrors[] = "<div class='alert alert-danger'>Please Add Book <strong> Author </strong></div>";
			    			}

			    			if(empty($pages)){
			    				$formerrors[] = "<div class='alert alert-danger'><strong> Title </strong> Must be Than 5 Caracteres</div>";
			    			}

			    			if(empty($lang)){
			    				$formerrors[] = "<div class='alert alert-danger'><strong> Title </strong> Must be Than 5 Caracteres</div>";
			    			}

			    			foreach ($formerrors as $error) {
			    				echo $error;
			    			}

			    		if (empty($formerrors)) {
			    			//			    				
		                		@$avatar = rand(0, 1000000) . '_' . $avatarName;
		                			                			                	
		                		@$file = rand(0, 1000000) . '_' . $fileN;
		                		
		                		
			                
			                //check if there is not book like whate they uplode
			                $check = checkItem('title', 'books', $title);
		    				if ($check == 1){
		    				
		    					$theMsg = "<div class='alert alert-danger'> This <strong>Book</strong> Reaaly Exist </div>";
	                    		redirectHome($theMsg, 'back', 3);

		    				} else {

		    					move_uploaded_file($avatartmp, "Admin/layout/images/books/" . $avatar);
		    					move_uploaded_file($fileP, "Admin/layout/fileuplodes/book/" . $file);		                	
		                			

		    					$stmt = $con->prepare("
	                    			INSERT INTO books(title, description, cat_id, tags, avatar, file, aprove, status, date_add, member_id, size, type, pages, author, lang) 
	                    			VALUES (:ztitle, :zdescription, :zcatid, :ztags, :zavatar, :zfile, 0, 1, now(), :zmember, :zsize, :ztype, :zpages, :zauthor, :zlang)");

		    					$stmt->execute(array(

		    						'ztitle' 			=> $title,
		    						'zdescription' 		=> $desc,
		    						'zcatid' 			=> $cat,	    						
		    						'ztags' 			=> $tags,
		    						'zavatar' 			=> $avatar,
		    						'zfile' 			=> $file,
		    						'zsize'				=> $fileS,
		    						'ztype'				=> $fileT,
		    						'zpages'			=> $pages,
		    						'zauthor'			=> $author,
		    						'zlang'				=> $lang,
		    						'zmember'			=> $id
		    									
		    					));	

		    					// success Message 
		    					$theMsg = ' <div class="alert alert-success">Successefly Book Add We Cheking your Book Before Publishid</div>';
                    			redirectHome($theMsg, 'back', 2);
		                	//
                    		  }
			    		}	
			    		
			    	}
			    	// End   page insert book detail to dataB
			    }elseif($do == 'EditBook') {
			    		
			    	$id = (isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 );
			    	$stmt = $con->prepare( "SELECT * FROM books WHERE ID = ? AND aprove = 1 LIMIT 1" );
		            $stmt->execute(array($id));
		            $books = $stmt->fetch(); 
		            $count = $stmt->rowCount();

		            if ($count > 0) { ?>
		            <!-- Start Forms Edit Books Detail -->
		            <div class="container editbook">		            	
	            		<form action="?do=Update" method="POST" enctype="multipart/form-data">
	            			<input type="hidden" name="req" value="upbook">
	            			<input type="hidden" name="id" value="<?php echo $id?>">
	            			<h4></h4>
	            			<div class="row">
	            				<div class="col-12 col-sm-12 col-md-7 col-lg-7">
	            					<label>Title</label>
	            					<input type="text" name="title" class="form-control col-12 col-sm-12 col-md-8 col-lg-8 mb-4" disabled="" value="<?php echo $books['title']?>">

		            				<label>Description</label>
		            				<textarea name="newdesc" id="desc" rows="6" class="form-control col-12 col-sm-12 col-md-8 col-lg-8 mb-2" placeholder="<?php echo $books['description']?>"></textarea>
		            				<input type="hidden" name="olddesc" value="<?php echo $books['description']?>">
	            				</div>
	            				<div class="col-12 col-sm-12 col-md-5 col-lg-5">
	            					<label> Author</label>
	            					<input type="text" name="author" id="author" class="form-control col-12 col-sm-12 col-md-6 col-lg-6 mb-3" value="<?php echo $books['author']?>">
	            					<input type="hidden" name="oldauthor" id="author"value="<?php echo $books['author']?>">

	            					<label style="display: block;"> Languge </label>
	            					<select class="custom-select form-control col-12 col-sm-12 col-md-6 col-lg-6 mb-3" name="lang" id="lang" style="display: inline-block;">
									  <option selected><?php echo $books['lang'] ?></option>
									  <option value="1">Arabic</option>
									  <option value="2">French</option>
									  <option value="3">English</option>
									  <option value="4">Spanish</option>
									  <option value="5">China</option>
									  <option value="6">Turkish</option>
									  <option value="7">Italy</option>
									  <option value="8">latine</option>
									</select>	
									
									<div class="clearfix"></div>

	            					<label> Pages Number</label>
	            					<input type="text" name="pages" id="pages" class="form-control col-12 col-sm-12 col-md-6 col-lg-6 mb-3" required="" value="<?php echo $books['pages']?>">

	            					<label> Book Image</label>
	            					<input type="file" name="avatar" class="form-control col-12 col-sm-12 col-md-6 col-lg-6 mb-3">
	            					<input type="hidden" name="oldavatar" value="<?php echo $books['avatar']?>">
	            				</div>
	            			</div>
	            			<button class="btn btn-success"><i class="fa fa-save"></i> UPDATE</button>
	            		</form>		            	
		            </div>
		            <!-- End   Forms Edit Books Detail -->
		            <?php }

			    }
			    // Session End 	

			    include $tpl . 'footer.php';
			} else {
				header('location: Login.php');
			}   	
	ob_end_flush();		