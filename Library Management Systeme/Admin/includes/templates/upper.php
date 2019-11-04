
<div class="upper">
	<div class="container">
		<img class="logo" src="layout/images/avatar/Untitled-1.png" style="width: 15%;">
		<div class="session">			
		<?php
		$stmt = $con->prepare("SELECT * FROM users WHERE ID = ?");
		$stmt->execute(array($_SESSION['ID']));
		$rows = $stmt->fetchAll();
		foreach ($rows as $row) {
			
			if(!empty($row['Avatar'])){
				echo"<img class='Avatarimage' src='layout/images/avatar/".$row['Avatar']. "'/>";			        				
			} else {
				echo"<img class='Avatarimage' src='layout/images/avatar/avatar.jpg'/>";
			}
		}
		?>						
		</div>
		
	</div>
</div>