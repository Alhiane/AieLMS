<?php session_start(); ?>

<?php $pageTitle = 'Login / Signup'; // page title ?>
<?php $noNavbar = ''; // disabled navbar ?>
<?php if (isset($_SESSION['ADname'])) { header('location: Admin/dashbord.php'); } ?>
<?php if (isset($_SESSION['user_session'])) {header('location: dashbord.php');} // user session ?>
<?php include 'init.php'; // import fils systeme ?>

<!-- Strat request -->

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$req = $_POST['req'];
    
    if ($req == 'login') {

        	@$user = $_POST['user'];
	        @$pass = $_POST['pass'];
	        @$hashedPass = sha1($pass);
	        // get detail from dataB
	        @$stmt = $con->prepare("SELECT ID, Username, Password, GroupID FROM users WHERE Username = ? AND Password = ?");
	        @$stmt->execute(array($user, $hashedPass));
	        @$row = $stmt->fetch();
	        @$count = $stmt->rowCount();
	        	// verify detaile 
	            if($count > 0){
	            
	            if ($row['GroupID'] == 1) {
	            	$_SESSION['ADname'] = $user;
            		$_SESSION['ID'] = $row['ID'];
	            	header('location: Admin/dashbord.php');
	            }else {
	            	@$_SESSION['user_session'] = $user;
	            	@$_SESSION['id_session'] = $row['ID'];
	            	header('location: dashbord.php');

	            }
	            exit();
	            } else {
	            	$theMsg = ' <div class="alert alert-danger"> Username or Password Wrrong</div>';
	            }
        }

    else{        
        	@$username = $_POST['username'];
        	@$password = $_POST['password'];
        	@$email = $_POST['email'];

        	@$hashdPass = sha1($password);
        	// verify user information
        	@$chek = checkItem("Username", "users", $username);

        	if ($chek > 0) {
        		$theMsg = ' <div class="alert alert-danger">This Account Really Exist</div>';
        	} else {
        		@$stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Regstatus, Date_add) VALUES (:zuser, :zpass, :zemail, 0, now())");
        		@$stmt->execute(array(
        			'zuser' 	=> $username,        			
        			'zpass' 	=> $hashdPass,
        			'zemail' 	=> $email
        		));
        		
        		$theMsg = ' <div class="alert alert-success"> successful Now Login To your Account</div>';

    			
        	}
        }        

}        
?>

<div class="pagelogin">
	<div class="login-signup" id="loginfor">
	    <h3 class="mb-3 text-center"> <a class="login"><span class="glyphicon glyphicon-log-in"></span> Login</a> |<a class="signup"> Signup</a> </h3>
	     <div class="loginform" >                    
	        <div>
	            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	            	<input type="hidden" name="req" value="login">
	                <input type="text"     id="username" name="user" class="form-control mb-3" placeholder="Username Or Email" required="">    
	                <input type="password" id="password" name="pass" class="form-control mb-3" placeholder="Password" required="">  
	                <button class="btn btn-success btn-block"> Login </button>  
	            </form>
	        </div>                    
	    </div>
	    
	    <div class="signupform">                    
	        <div>
	            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	            	<input type="hidden" name="req" value="signup">
	                <p id="userreq"></p>
	                <input type="text"     id="uuser" name="username" class="form-control mb-3" placeholder="Username Or Email" required="" onkeyup ="user('userreq')">    	                
	                <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Password" required=""> 
	                <p class="emailreq"></p>
	                <input type="Email"    id="email" name="email" class="form-control mb-3" placeholder="Email For Validate " required="" onkeyup="email('emailreq')"> 
	                <button class="btn btn-primary btn-block"> Signup </button>  
	            </form>
	        </div>	        
	    </div>
	 </div>
	 <?php echo @$err; 
	 echo @$theMsg; ?>
	 <div class="prevlink"> <a href="index.php"><i class="fa fa-chevron-left"></i> Redirect To Home Page </a> </div>
</div>
<?php include $tpl . 'mainfooter.php'; ?>	
<?php include $tpl .'footer.php'; ?>