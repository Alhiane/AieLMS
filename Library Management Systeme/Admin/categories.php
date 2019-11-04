<?php
	
	ob_start();

	session_start();
	
	$pageTitle = 'categories';
	
	if (isset($_SESSION['ADname'])) {
	    
	    include 'init.php';

	    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	    if($do == 'Manage')			{
	    	//Start categorey manage
	    	
	    	$stmt = $con->prepare("SELECT * FROM categories WHERE Parent = 0");
	    	$stmt->execute();
	    	$cats = $stmt->fetchAll();
	    	?>



	    	<div class="container">
	    		<div class="CatManage">
	    			<div class="card-header white bg-primary"><i class="fa fa-tasks"></i> Categories 
	    				<div class="Option pull-right">				  						  		
				  		<span class="active" data-view="full" ><i class="fa fa-th-list"></i></span> 
				  		<span  data-view="classic" ><i class="fa fa-align-justify"></i></span> 
				  	</div>
	    			</div>	    			
	    			<div class="card-body border bg-light">
	    				<?php
	    				foreach ($cats as $cat) {
	    						    				
	    				echo "<div class='cat'>";
	    					echo "<a href='categories.php?do=Edit&ID=".$cat['ID']."'><h4><i class='fa fa-tag'></i>".' ' . $cat['Name'] ."</h4></a>";	    					
	    					echo "<div class='full-view'>";
	    					// description start
	    						echo "<p>"; 
	    						if ($cat['Description'] == '') {
				    			echo "<div class='nodescription'>This Category has no description</div>";
				    			} else { 
					    		echo $cat['Description']; } 
					    		echo "</p>";
					    	// description end	
					    	// visibility start
					    		if ($cat['Visibility'] == 0) { echo '<span class="hiddeen"><i class="fa fa-eye-slash"></i> Hidden</span>';} else {echo '<span class="Visible"><i class="fa fa-eye"></i> Visible</span>';}
					    	// visibility end
					    	// public start
					    		if ($cat['Public'] == 0) { echo '<span class="private"><i class="fa fa-lock"></i> Private Cat</span>';} else {echo '<span class="Public"><i class="fa fa-unlock"></i> Public</span>';}
					    	// public end
					    	// Sub Cat start
					    		$stmt2 = $con->prepare("SELECT * FROM categories WHERE Parent = {$cat['ID']}");
					    		$stmt2->execute();
					    		$subcats = $stmt2->fetchAll();
					    		if (! Empty($subcats)) {					    			
					    		echo "<h6><i class='fa fa-bars'></i> Chiled Cats</h6>";
					    		echo "<ul class='list-unstyled'>";
					    		foreach ($subcats as $c) {
					    			echo "<li><a href='categories.php?do=Edit&ID=".$c['ID']."'><h6>".'' . $c['Name'] ."</h6></a></li>";
					    		}
					    		echo "</ul>";
					    		}
					    	// Sub Cat end					    			
	    					echo "</div>";
	    				echo "</div>";
	    				echo "<hr>";

	    				} ?>

	    			</div>
	    			<a href="categories.php?do=Add"><button class="btn btn-primary btn-block Add"><i class="fa fa-pencil"></i> Creat New Categorey</button></a>
	    		</div>
	    	</div>

	    	<?php
	    	//Start categorey manage
	    } elseif ($do == 'Add') 	{ 
	    	// Start Add Categorey Page
	    	?>

	    	<div class="container cretcat">
	    		<div class="card-header bg-primary"><h2 class="text-center"><i class="fa fa-pencil"></i> Creat New Categorey</h2></div>
	    		<form action="?do=Insert" method="POST">
	    		<div class="form-element mb-2 card-body bg-light">	    			
	    			<input type="text" class="form-control mb-2" name="Name" placeholder="Categorey Name">
	    			<input type="text" class="form-control mb-2" name="order" placeholder="Categorey Ordering">		
	    			<select class="custom-select mb-2" name="parent">
	    				<option selected value="0"> Parent </option>
	    				<?php
			        		$stmt = $con->prepare("SELECT * FROM categories WHERE Parent = 0");
			        		$stmt->execute();
			        		$cats = $stmt->fetchAll();
			        		foreach ($cats as $cat) {
			        			
			        			echo "<option value='". $cat['ID'] ."'> " . $cat['Name'] . " </option>";
			        		}
			        	?>	    				
	    			</select>
	    			<div class="form-control swi mb-2 switch-wrap d-flex justify-content-between">
		    			<div class="form-switche">
		    				<p class="v">Visibility</p>
							<div class="primary-switch">
								<input id="Visibility-no default-switch" name="Visibility" type="checkbox hidden" value="0" checked="">
								<input id="Visibility-yes default-switch" name="Visibility" type="checkbox" value="1">
								<label for="Visibility-yes default-switch"></label>
							</div>
						</div>	

						<div class="form-switche">
		    				<p class="p">Public</p>
							<div class="primary-switch">
								<input id="Public-no default-switch" name="Public" type="checkbox hidden" value="0" checked="">
								<input id="Public-yes default-switch" name="Public" type="checkbox" value="1">
								<label for="Public-yes default-switch"></label>
							</div>
						</div>	
						
	    			</div>
	    			<textarea class="form-control mb-2" name="description"></textarea>
	    		</div>
	    		<button class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Creat & Save</button>
	    		</form>
	    	</div>
	    	
	    	<?php
	    	// End Add Categorey Page
	    } elseif ($do == 'Insert') 	{
	    	// Start Insert  Page => DB
	    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	    		echo "<div class='container'>";
	    		echo "<div class='insert'>";
	    		
	    		$name 		= $_POST['Name'];
	    		$order 		= $_POST['order'];
	    		$parent 	= $_POST['parent'];
	    		$visibility = $_POST['Visibility'];
	    		$public 	= $_POST['Public'];
	    		$desc 		= $_POST['description'];

	    		if ($visibility > 0) {
	    			
	    			$vis = 1;
	    		}else {
	    			$vis = 0;
	    		}

	    		if ($public > 0) {
	    			
	    			$pic = 1;
	    		}else {
	    			$pic = 0;
	    		}

	    		$formerrors = array();

	    		if (empty($name)) {	    			
					$formerrors[] = '<div class="alert alert-danger">you cant less Categorey Name Empty</div>';                	
	    		}
	    		if (strlen($name) < 4) {	    			
					$formerrors[] = '<div class="alert alert-danger">you cant less Categorey Name Than 4 characters</div>';                	
	    		}

	    		if (empty($desc)) {	    			
					$formerrors[] = '<div class="alert alert-danger">you cant less Categorey Description Empty</div>';                	
	    		}

	    		foreach ($formerrors as $error) {
	    			
	    			echo $error;

	    		}

	    		if (empty($formerrors)) {
	    			
	    			$check = checkItem("Name", "categories", $name);

	    			if ($check == 1) {	    				
	    				$theMsg = '<div class="alert alert-warning">This Categorey Really Exist</div>';
	    				redirectHome($theMsg, 'back', 5); 
	    			} else {

	    				$stmt = $con->prepare("INSERT INTO categories(Name, Description, Visibility, Public, Parent, ordering)
	    					VALUES (:zname, :zdesc, :zvis, :zpic, :zparent, :zorder)");
	    				$stmt->execute(array(

	    					'zname'		 	=> $name,
	    					'zdesc' 		=> $desc,
	    					'zvis'	   		=> $vis,
	    					'zpic' 			=> $pic,
	    					'zparent' 		=> $parent,
	    					'zorder'	 	=> $order


	    				));

	    				// 	Message Success
                    		$theMsg = ' <div class="alert alert-success">'. $stmt->rowCount() .' Record Inserted In Database</div>';
                    		redirectHome($theMsg, 'back', 5); 
	    			}



	    		}
	    	} else {
	    		$theMsg = '<div class="alert alert-warning">You Cant Browse This Page </div>';
	    		redirectHome($theMsg, 'back', 5);         
	    	}

	    	echo "</div>";
    		echo "</div>";
	    	// End Insert  Page => DB
	    } elseif ($do == 'Edit') 	{
	    	// Start Edit Categorey Page
	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$stmt = $con->prepare( "SELECT * FROM categories WHERE ID = ? LIMIT 1" );
	    	$stmt->execute(array($id));
	    	$row = $stmt->fetch();
			$count = $stmt->rowCount();	
			if ($stmt->rowCount() > 0) {
			    	
	    	?>
	    	<div class="container cretcat">
	    		<div class="card-header bg-primary"><h2 class="text-center"><i class="fa fa-edit"></i> Edit Categorey</h2></div>
	    		<form action="?do=Update" method="POST">
	    		<div class="form-element mb-2 card-body bg-light">	  
	    			<input type="hidden" name="ID" value="<?php echo $row['ID']?>">  			
	    			<input type="text" class="form-control mb-2" value="<?php echo $row['Name'];?>" name="Name" placeholder="Categorey Name">
	    			<input type="text" class="form-control mb-2" name="order" value="<?php echo $row['ordering'];?>" placeholder="Categorey Ordering">		
	    			<select class="custom-select mb-2" name="parent">
	    				<option selected value="0"> Parent </option>
	    				<option value="1"> cat name 1 </option>
	    				<option value="2"> cat name 2</option>	    				
	    			</select>
	    			<div class="form-control swi mb-2 switch-wrap d-flex justify-content-between">
		    			<div class="form-switche">
		    				<p class="v">Visibility</p>
							<div class="primary-switch">
								<input id="Visibility-no default-switch" name="Visibility" type="checkbox hidden" value="0" <?php if($row['Visibility'] == 0){ echo "checked"; }?>>
								<input id="Visibility-yes default-switch" name="Visibility" type="checkbox" value="1" <?php if($row['Visibility'] == 1){ echo "checked"; }?>>
								<label for="Visibility-yes default-switch"></label>
							</div>
						</div>	

						<div class="form-switche">
		    				<p class="p">Public</p>
							<div class="primary-switch">
								<input id="Public-no default-switch" name="Public" type="checkbox hidden" value="0" <?php if($row['Public'] == 0){ echo "checked"; }?>>
								<input id="Public-yes default-switch" name="Public" type="checkbox" value="1" <?php if($row['Public'] == 1){ echo "checked"; }?>>
								<label for="Public-yes default-switch"></label>
							</div>
						</div>	
						
	    			</div>
	    			<textarea class="form-control mb-2" placeholder="<?php echo $row['Description'];?>" name="description"><?php echo $row['Description'];?></textarea>
	    		</div>
	    		<button class="btn btn-success btn-block"><i class="fa fa-save"></i> Save changes</button>
	    		</form>
	    	</div>

	    	<?php }
	    	// End Edit Categorey Page
	    } elseif ($do == 'Update') 	{
	    	// Start Update Categorey => DB
	    	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	    		echo "<div class='container'>";
	    		echo "<div>";

	    		$id 		= $_POST['ID'];
	    		$name 		= $_POST['Name'];
	    		$order 		= $_POST['order'];
	    		$parent 	= $_POST['parent'];
	    		$visibility = $_POST['Visibility'];
	    		$public 	= $_POST['Public'];
	    		$desc 		= $_POST['description'];



	    		$formerrors = array();

	    		if (empty($name)) {	    			
					$formerrors[] = '<div class="alert alert-danger">you cant less Categorey Name Empty</div>';                	
	    		}
	    		if (strlen($name) < 4) {	    			
					$formerrors[] = '<div class="alert alert-danger">you cant less Categorey Name Than 4 characters</div>';                	
	    		}

	    		if (empty($desc)) {	    			
					$formerrors[] = '<div class="alert alert-danger">you cant less Categorey Description Empty</div>';                	
	    		}

	    		foreach ($formerrors as $error) {
	    			
	    			echo $error;

	    		}

	    		if (empty($formerrors)) {
				
					$stmt = $con->prepare("UPDATE categories SET Name = ?, ordering = ?, Description = ?, Visibility = ?, Public = ?, Parent = ? WHERE ID = ?");
                	$stmt->execute(array($name, $order, $desc, $visibility, $public, $parent, $id));	

                	// Messag Success 

                	$theMsg= ' <div class="alert alert-success"> '. $stmt->rowCount() . ' Record Update</div>';
                    redirectHome($theMsg, 'back');    			

	    		} else {

                        echo "Sorry You Cant Browse This page Directly";
                        redirectHome($theMsg);

                    }

	    		echo "</div>";
	    		echo "</div";
	    	}
	    	// End Update Categorey => DB
	    } elseif ($do == 'Delete') 	{
	    	// Start Delete Categorey => DB
	    	echo "<div class='container'>";
    		echo "<div class='update'>";

	    	$id = (isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 );
	    	$Check = checkItem('ID', 'categories', $id);

	    	if($Check > 0) {

	    		$stmt = $con->prepare( "DELETE FROM categories WHERE ID = :zid" );
                $stmt->bindParam(":zid", $id);
                $stmt->execute();

                $theMsg= ' <div class="alert alert-success">' . $stmt->rowCount() . ' Record DELETED In DB</div>';
                redirectHome($theMsg, 'back');
	    	 }else {

                $theMsg= '<div class="alert alert-danger"> Sorry This ID Not existe</div>';
                redirectHome($theMsg);
                        
               }

               echo "</div>";
    			echo "</div>";
	    	// End Delete Categorey => DB
	    } 

	    include $tpl . 'footer.php';

	} else {

		header('Location: login.php');

    	exit();
	}    

	ob_end_flush();

?>	
	                
