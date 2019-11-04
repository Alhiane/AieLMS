      
      <div class="nav-menu" id="nav-menu">
           <div class="container">
           <nav>
               <a href="index.php" class="logo">
                   <img src="layout/images/avatar/logo4.png" style="width: 12%;">
               </a>
               <div class="navbar">
                   <ul>  
                      <!-- button toogle dropdown menu -->          
                      <div class="bars"><li class="br"><a><i class="fa fa-bars"></i></a></li></div>                         
                   </ul>                   
               </div>                                                                 
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
      </div>