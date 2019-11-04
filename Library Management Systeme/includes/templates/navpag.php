<div class='navpag'>
	<div class="logo">
		<h2><?php echo '#'. @$pageTitle ?>	</h2>
	</div>
	<div class="menu">
		<div class="links  container">
			<a href="index.php"><i class="fa fa-home"></i></a>
      <ul>        
				<li> <a href=""> Home </a> </li>
				<li> <a href=""> Home </a> </li>
				<li> <a href=""> Home </a> </li>
				<div class="pull-right">	           					
          <li class="bars"> <i class="fa fa-bars"></i> </li>			
				</div>
        <a href="dashbord.php"><li class="useravatar">          
          <!-- Get user information session In DB -->
          <?php 
              if(isset($_SESSION['user_session'])) {
                $user = $_SESSION['user_session'];
                $stmt = $con->prepare("SELECT * FROM users WHERE Username = ?");
                $stmt->execute(array($user));
                $rows = $stmt->fetchAll();

                foreach ($rows as $row) {
                   if(!empty($row['Avatar'])) {
                      ?><img src="Admin/layout/images/avatar/<?php echo $row['Avatar'] ?>"><?php
                   } else {
                      ?> <img  src="Admin/layout/images/avatar/avatar.jpg" style="border:none; cursor: pointer;"> <?php
                   }
                 } 
              } else {
                ?> <a href="login.php"> <i class="fa fa-user nosession"></i> </a> <?php
              }
           ?>
         </li></a>         
			</ul>	
		</div>
    <!-- Dropdown -->
       <ul class="dropdown off">
          <div class="row">
            <?php 
            $stmt = $con->prepare("SELECT * from categories  WHERE Parent = 0");
            $stmt->execute();
            $cats = $stmt->fetchAll();

            foreach($cats as $cat) {   ?>
            <!-- first categories -->
            <div class="col-md-3 col-sm-6">
              <!-- For Count money book issus in each category -->
              <?php $cat_id = $cat['ID'];
                    $stmtcount = $con->prepare("SELECT * from books where cat_id = ?"); 
                    $stmtcount->execute(array($cat_id)) ;
                    $count1 = $stmtcount->fetch() ;
                    $count2 = $stmtcount->rowCount();?>
              <a href="categories.php?id=<?php echo $cat['ID']?>&pagename=<?php echo str_replace(' ', '-', $cat['Name'])?>"> <h4><?php echo $cat['Name']; ?> <span class="count"><?php echo $stmtcount->rowCount(); ?></span> </h4> </a>
              <h6> <?php echo $cat['Description']; ?> </h6>
            </div>
            <!-- End first categories -->
            <?php } ?>                
          </div>
        </ul>
    <!-- Dropdown -->

    <!-- window uploade -->
    <div class="">
      
    </div>
    <!-- window uploade -->
	</div>
</div>