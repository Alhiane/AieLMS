<?php
	
	ob_start();

	session_start();
	
	$pageTitle = 'Members';
	
	if (isset($_SESSION['ADname'])) {
	    
	    include 'init.php';

	    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	    if($do == 'Manage')			{ 

	    	$query ='';

	    	$msg='';
            
            if(isset($_GET['page']) && $_GET['page'] == 'WaitingAproval'){

                $query = 'AND Regstatus = 0';
                $msg = 'There Is No Member Waiting Aproval!';
            }else{
            	$msg = 'There Is No Member!';
            }

	    	$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ");

	    	$stmt->execute();

	    	$rows = $stmt->fetchAll();

	    	if (Empty($rows)) {
								  			
	  			?>
	  		<div class="container">
	  			<div class="memberempty">
	  				<h5><?php echo $msg?></h5>
	  			</div>
	  			<div class="addnewmemb">
	  				<a href="members.php?do=Add"> <button class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Add New Member</button> </a>
	  			</div>
	  		</div>

	  			<?php	

	  		}else{

	   	?>

	    	<div class="container">
					<div class="order-table-members">
							<div class="btn-group" role="group" aria-label="Basic example">
							  <a href="members.php"><button type="button" class="btn btn-dark"><i class="fa fa-bars"></i> All</button></a>			
							  <a href="members.php?do=Manage&page=WaitingAproval"><button type="button" class="btn btn-success order-table-members5"><i class="fa fa-user-plus"></i> Only Waiting Aproval
							<?php
			    			$aprove = checkItem("Regstatus", "users", 0);
			    			if ($aprove > 0) {
			    				echo '<span class="badge badge-danger">' .' '.checkItem("Regstatus", "users", 0).'</span>';
			    			} ?>
							  </button><a>
							</div>
						</div>
					<div class="memberslist">
						<div class="form-group input-group">
					        <input class="form-control search" type="search" placeholder="Enter Name, Email, Username, ... then Press Enter">
					        <span class="input-group-btn">
					            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
					            </button>
					        </span>
				    	</div>
							<div class="table">
								<table class="table">
								  <thead>
								    <tr>
								      <th class="avatar" scope="col"></th>
								      <th scope="col">#ID</th>
								      <th scope="col">Username</th>
								      <th scope="col">Fullname</th>				      
								      <th scope="col">Email</th>
								      <th scope="col">Joined In</th>
								      <th scope="col">Total Uplodes</th>
								      <th></th>				      				     
								    </tr>
								  </thead>
								  <tbody>
								  	<?php
								  		foreach ($rows as $row) {	
								  			echo "<tr>";
								  				echo "<td class='avatar'>";
								  				if(empty($row['Avatar'])){
								  					echo"<img class='Avatarimage' src='layout/images/avatar/avatar.jpg'>";
								  				} else {
								  					echo"<img class='Avatarimage' src='layout/images/avatar/".$row['Avatar']. "'/>";
								  				}
								  				echo"</td>";
								  				echo "<th scope='row'>" . $row['ID'] . "</th>";
								  				echo "<td>" . $row['Username'] . "</td>";
								  				echo "<td>" . $row['Fullname'] . "</td>";
								  				echo "<td>" . $row['Email'] . "</td>";
								  				echo "<td>" . $row['Date_Add'] . "</td>";
								  				  $st1 = $con->prepare('SELECT * from books where member_id = ?');
							      				  $st1->execute(array($row['ID']));
							      				  $infos = $st1->fetch();
							      				  $count = $st1->rowCount();						      				  
								  				echo "<td>". $count ." </td>";
								  				echo "<td class='control-members'>";
								  					echo "<a href=''> <button class='btn btn-primary'><i class='fa fa-user'></i></button> </a>";
								  					echo "<a href='members.php?do=Edit&ID=".$row['ID']."'> <button href='test.php' class='btn btn-warning'><i class='fa fa-edit'></i></button> </a>";								 
													echo "<a href='members.php?do=Delete&ID=".$row['ID']."'> <button class='btn btn-danger'><i class='fa fa-remove'></i></button> </a>";									
								  					if ($row['Regstatus'] == 0) {
								  						echo "<a href='members.php?do=Activate&ID=".$row['ID']."'> <button class='btn btn-success'><i class='fa fa-check'></i></button> </a>";
								  					}
								  				echo "</td>";
								  			echo "<tr>";
								  		} ?>						    
								  </tbody>
								</table>
							</div>
							<a href="members.php?do=Add"> <button class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Add New Member</button> 
							</a>
						</div>
				</div>
				<?php } ?>
        <?php
	    } elseif ($do == 'Add') 	{ 


	    	?>

	    	<div class="container">
	    		<form action="?do=Insert" method="POST" enctype="multipart/form-data">	    			
		    		<div class="row Editmemberinfo">
		    			<div class="info col-12 col-sm-12 col-md-3 col-lg-3">
		    				<div class="card-body bg-light live-perview">		    					
		    					<div class="infoavatar">
		    						<img src="" id="img">		
		    					</div>	
		    					<span><i class="fa fa-slack"></i><h5></h5></span>
		    					<span><i class="fa fa-user"></i><h6 class="name"></h6></span>
		    					<span><i class="fa fa-envelope"></i><h6 class="email"></h6></span>
		    				</div>
		    			</div>
		    			<div class="input col-9">
		    				<div class="col-7 mb-3 user">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="text" name="user"  class="form-control live-user" id="inlineFormInputGroupUsername" placeholder="Username">
						      </div>

						    </div>

						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Password</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="password" name="password"  class="form-control" id="inlineFormInputGroupUsername" placeholder="Password">						       					        
						      </div>

						    </div>

						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Fullname</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="text" name="fullname" class="form-control live-name" id="inlineFormInputGroupUsername" placeholder="Fullname">
						      </div>

						    </div>
						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Email</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="email" name="email" class="form-control live-email" id="inlineFormInputGroupUsername" placeholder="Email">
						      </div>

						    </div>
						    

						    <div class="col-4 addavatar">
						    	<span><i class="fa fa-image"></i></span>
						    	<span><h6>Select Image</h6></span>
						    	<input type="file" name="avatar" onchange="img()">
						    	
						    </div>

						    <div class="col-7 mb-3"><button class="btn btn-success btn-block">Add</button></div>
		    			</div>
		    		</div>			    							
		    	</form>
	    	</div>

	    	
	    	<?php
		
	    } elseif ($do == 'Insert') 	{
	    	
	    	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	    		echo "<div class='container'>";
	    		echo "<div class='insert'>";
	    			
	    			// Uplode Varibale Avatar	    			

	    			$avatarName 	= strip_tags($_FILES['avatar']['name']);
	    			$avatarSize 	= strip_tags($_FILES['avatar']['size']);
	    			$avatarTmp	 	= strip_tags($_FILES['avatar']['tmp_name']);
	    			$avatarType 	= strip_tags($_FILES['avatar']['type']);

	    			// Allowed file type 

	    			$avatarAllowedExetention = array("jpg", "jpeg", "png", "gif");

	    			@$avatarExetention =strtolower(end(explode('.', $avatarName)));   

	    			// Get Variable from FROM

	    			$fullname = strip_tags($_POST['fullname']);
	    			$username = strip_tags($_POST['user']);
	    			$password = strip_tags($_POST['password']);
	    			$email 	  = strip_tags($_POST['email']);

	    			$hasdPass = sha1($_POST['password']);

	    			// Check For Errors

	    			$formerrors = array();

	    			if(strlen($fullname) < 5 ){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Than 5 caracteres </div>";
	    			}

	    			if(strlen($fullname) > 20){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Hight then 20 caracteres </div>";
	    			}

	    			if(empty($fullname)){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Empty</div>";
	    			}

	    			if(strlen($username) < 4){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Username </strong>then 4 caracteres </div>";
	    			}

	    			if(empty($username)){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Username </strong>Empty</div>";
	    			}

	    			if(empty($password)){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Password </strong>Empty</div>";
	    			}

	    			if(strlen($password) < 6){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Password </strong>Then 6 Caracteres</div>";
	    			}

	    			if(empty($email)){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Email </strong>Empty</div>";
	    			}

	    			if (!empty($avatarName) && !in_array($avatarExetention, $avatarAllowedExetention)) {
	    				$formerrors[] = "<div class='alert alert-danger'>This Type Is not<strong>Allowed</strong></div>";
	    			}

	    			if ($avatarSize > 4194304) {
	    				$formerrors[] = "<div class='alert alert-danger'>Avatar can't be Large than<strong>4MB</strong></div>";
	    			}

	    			 foreach ($formerrors as $error) {
                        echo $error;
                    }

                    if(empty($formerrors)){

                    	

                    	if(empty($avatarName)){
                    		$avatar='';
                    	}else{
                    		$avatar = rand(0, 1000000) . '_' . $avatarName;
                    	}
                    	move_uploaded_file($avatarTmp, "layout/images/avatar/" . $avatar);

                    	$chek = checkItem("Username", "users", $username);
                    	$chek = checkItem("Email", "users", $email);

                    	if($chek == 1){

                    		$theMsg = "<div class='alert alert-danger'> This <strong> Username </strong> Or <strong> Email </strong> Reaaly Exist </div>";
                    		redirectHome($theMsg, 'back', 3);
                    	} else {

                    		// 	Insert User Information To DB
                    		$stmt = $con->prepare("
                    			INSERT INTO users(Username, Fullname, Password, Email, Regstatus, Date_Add, Avatar) 
                    			VALUES (:zuser, :zname, :zpass, :zemail, 1, now(), :zavatar)");

                    		$stmt->execute(array(

                    			'zuser' 	=> $username,
                    			'zname' 	=> $fullname,
                    			'zpass' 	=> $hasdPass,
                    			'zemail' 	=> $email,
                    			'zavatar' 	=> $avatar

                    		));

                    		// 	Message Success
                    		$theMsg = ' <div class="alert alert-success">'. $stmt->rowCount() .' Record Inserted In Database</div>';
                    		redirectHome($theMsg, 'back', 2);                    		

                    	}

                    }

                }else{

                	$theMsg = '<div class="alert alert-warning">You Cant Browse This Page </div>';

                }

	    		echo "</div>";
	    		echo "</div>";
	    	

	    } elseif ($do == 'Edit') 	{


	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
                
                    $stmt = $con->prepare( "SELECT * FROM users WHERE ID = ? LIMIT 1" );
                    $stmt->execute(array($id));
                    $row = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if ($stmt->rowCount() > 0) { 
	    	?>

	    	<div class="container">
	    		<form action="?do=Update" method="POST" enctype="multipart/form-data">
	    			<input type="hidden" name="ID" value="<?php echo $row['ID']?>">
		    		<div class="row Editmemberinfo">
		    			<div class="info col-12 col-sm-12 col-md-3 col-lg-3">
		    				<div class="card-body bg-light">		    					
		    					<div class="infoavatar">
		    						<img src="layout/images/avatar/<?php echo $row['Avatar']?>">		
		    					</div>	
		    					<span><i class="fa fa-slack"></i><h5><?php echo $row['Username']?></h5></span>
		    					<span><i class="fa fa-user"></i><h6> <?php echo $row['Fullname']?></h6></span>
		    					<span><i class="fa fa-envelope"></i><h6><?php echo $row['Email']?></h6></span>
		    				</div>
		    			</div>
		    			<div class="input col-9">
		    				<div class="col-7 mb-3 user">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="text" name="user" value="<?php echo $row['Username']?>" class="form-control" id="inlineFormInputGroupUsername" placeholder="Username">
						      </div>

						    </div>

						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Password</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="password" name="newPassword"  class="form-control" id="inlineFormInputGroupUsername" placeholder="Password">

						        <input type="hidden" name="oldPassword" value="<?php echo $row['Password']?>" class="form-control" id="inlineFormInputGroupUsername" placeholder="Password">
						        
						      </div>

						    </div>

						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Fullname</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="text" name="fullname" value="<?php echo $row['Fullname']?>" class="form-control" id="inlineFormInputGroupUsername" placeholder="Fullname">
						      </div>

						    </div>
						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Email</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control" id="inlineFormInputGroupUsername" placeholder="Email">
						      </div>

						    </div>
						    <div class="col-7 mb-3">
						      
						      <label class="sr-only" for="inlineFormInputGroupUsername">Phone Number</label>
						      <div class="input-group">
						        <div class="input-group-prepend">
						          <div class="input-group-text"><i class="fa fa-asterisk"></i></div>
						        </div>
						        <input type="email" name="phone" class="form-control" id="inlineFormInputGroupUsername" placeholder="Phone Number">
						      </div>

						    </div>

						    <div class="col-4 addavatar">
						    	<span><i class="fa fa-image"></i></span>
						    	<span><h6>Change Image</h6></span>
						    	<input type="file" name="newavatar">
						    	<input type="hidden" name="oldavatar" value="<?php echo $row['Avatar']?>">
						    </div>

						    <div class="col-7 mb-3"><button class="btn btn-success btn-block">Update</button></div>
		    			</div>
		    		</div>			    							
		    	</form>
	    	</div>

	    	<?php
	    		}else{
	    			$theMsg = '<div class="alert alert-danger">There Is No Such Id</div>';
	    			redirectHome($theMsg);
	    		}
	    } elseif ($do == 'Update') 	{
	    	
	    	if($_SERVER['REQUEST_METHOD'] == 'POST'){

	    		echo "<div class='container'>";
	    		echo "<div class='update'>";


	    			$avatarName 	= strip_tags($_FILES['newavatar']['name']);
	    			$avatarSize 	= strip_tags($_FILES['newavatar']['size']);
	    			$avatarTmp	 	= strip_tags($_FILES['newavatar']['tmp_name']);
	    			$avatarType 	= strip_tags($_FILES['newavatar']['type']);

	    			// Allowed file type 

	    			$avatarAllowedExetention = array("jpg", "jpeg", "png", "gif");

	    			@$avatarExetention =strtolower(end(explode('.', $avatarName))); 

	    			$id 	  = $_POST['ID'];	    			
	    			$user 	  = $_POST['user'];	
	    			$fullname = $_POST['fullname'];	    				    			
	    			$email 	  = $_POST['email'];
	    			

	    			$password = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);


	    			$formerrors = array();

	    			if(strlen($fullname) < 5 ){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Fullname </strong>Than 5 caracteres </div>";
	    			}

	    			if(strlen($user) < 5 ){
	    				$formerrors[] = "<div class='alert alert-danger'> You can't Less<strong> Username </strong>Than 5 caracteres </div>";
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
                    		$avatar = $_POST['oldavatar'];
                    	
                    	}else {
                    		$avatar = rand(0, 1000000) . '_' . $avatarName;
                    	}
                    	move_uploaded_file($avatarTmp, "layout/images/avatar/" . $avatar);

                    	// Update Information user in To DB

                    	$stmt = $con->prepare("UPDATE users SET Username = ?,Fullname = ?, Email = ?, Password = ?, Avatar = ? WHERE ID = ?");
                    	$stmt->execute(array($user, $fullname, $email, $password, $avatar, $id));

                    	// Message success UPDATE

                    	$theMsg= ' <div class="alert alert-success"> '. $stmt->rowCount() . ' Record Update</div>';
                        redirectHome($theMsg, 'back');
                    }

	    	}else {

                        echo "Sorry You Cant Browse This page Directly";
                        redirectHome($theMsg);

                    }

                    echo '</div>';
                    echo '</div>';

	    } elseif ($do == 'Delete') 	{
	    	
    		echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'users', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "DELETE FROM users WHERE ID = :zuser" );
                $stmt->bindParam(":zuser", $id);
                $stmt->execute();

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record DELETED In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg);
                        
               }

               echo "</div>";
    			echo "</div>";
	    }  elseif ($do = 'Activate') {
	    	// Activat new member
	    	echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'users', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "UPDATE users SET Regstatus = 1 WHERE ID = ?" );
                
                $stmt->execute(array($id));

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record UPDATE In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg);
                        
               }

               echo "</div>";
    			echo "</div>";

	    	// Activat new member
	    }

	    include $tpl . 'footer.php';

	} else {

		header('Location: login.php');

    	exit();
	}    

	ob_end_flush();

?>	
	                
