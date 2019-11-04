<?php
session_start();
    if(isset($_SESSION['ADname'])){
        header("location: dashbord.php");
    }
$noNavbar= '';
$noUpper='';

$pageTitle = 'Login';

include 'init.php';
include $tpl . 'header.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);
        
        $stmt = $con->prepare("SELECT ID, Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

            if($count > 0){

            $_SESSION['ADname'] = $username;
            $_SESSION['ID'] = $row['ID'];
            header('location: dashbord.php');
            exit();
            }
        }    
?>
<form class="login login col-12 col-md-5 col-md-4 col-lg-4" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">   
    <div class="card-header">
       <h1><i class="fa fa-user"></i> Admin Login </h1>
    </div> 
    <div class="card-body">
        <input type="text"     name="user" placeholder="Username" autocomplete="off">
        
        <input type="password" name="pass" placeholder="Password" autocomplete="new-password">
        <input type="submit" value="Login">
    <!--    <input type="submit" value="Forger Password!!"> -->
    </div>
</form>
