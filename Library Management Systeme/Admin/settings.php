<?php 
session_start();
$pageTitle = 'Settings';
include 'init.php'; ?>

	<!-- Start page Settings content -->
	<div class="container">
		<div class="setting-tab">
			<span id="reponse" class="reponse">  </span>
			<!-- Start tab element -->
			<ul>
				<li data-class="general" class="active">Generale</li>
				<li data-class="admins">Admins</li>
				<li data-class="about">About us</li>
				<li data-class="policy">Policy</li>
				<li data-class="upp">Upparence</li>
				<li data-class="sliders">Sliders</li>
				<li data-class="con">Controle</li>
				<li data-class="seo">SEO</li>
				<li data-class="links">Links</li>
			</ul>
			<!-- Start tab content -->
			<div class="content">
				<div class="general each"><!-- @ Start general Tab -->
					
						<div class="row">							
							<div class="col-4 title"> <!-- setting library title & description -->								
								<label> Library Title </label>
								<input type="text" name="title" id="title" class="form-control" placeholder="Title here">
								<label> Description </label>
								<textarea type="text" name="desc" id="desc" class="form-control" rows="4" placeholder="Library Description here"></textarea>			
							</div>
							<div class="col-4 logo"> <!-- setting library Logo -->								
								<label> Logo </label>
								<input type="file" name="logo" class="form-control" id="logo">
								<img src="">
								<label class='note'>only ( png,jpeg,gif ) Extension Allowed </label>								
							</div>
							<div class="col-4"> <!-- setting library icon / navigateur icon -->								
								<label> Icon  </label>
								<input type="file" name="icon" id="icon" class="form-control">
								<label class="note">only ( png,jpeg,gif ) Extension Allowed </label>								
							</div>							
						</div>	
						<button class="btn btn-dark" onclick='sett("gen")' id="save"> Save </button>
					
				</div><!-- End general Tab -->
				<div class="admins each"><!-- @ Start Admins Tab -->
					<div class="row">
						<div class="col-4 old-admins">
							<h3> Admins Existe </h3>
							<div class="admin">
								<img src="layout/images/avatar/640455_avatar.png">
								<h4>Alhiane Lahcen</h4>
								<p> Directeur </p>
							</div>

							<div class="admin">
								<img src="layout/images/avatar/640455_avatar.png">
								<h4>Alhiane Lahcen</h4>
								<p> Directeur </p>
							</div>							
						</div>
						<div class="col-5 select">
							<h3> Select New Admin </h3>
							<div class="users">
								<div class="user"><!-- Radio select new admin -->
									<input type="radio" value="5" id="user">
									<img src="layout/images/avatar/640455_avatar.png">
									<h4> Alhiane lahcen </h4>
								</div>
								<div class="user"><!-- Radio select new admin -->
									<input type="radio" value="2" id="user">
									<img src="layout/images/avatar/640455_avatar.png">
									<h4> Alhiane lahcen </h4>
								</div>
								<div class="user"><!-- Radio select new admin -->
									<input type="radio" value="4" id="user">
									<img src="layout/images/avatar/640455_avatar.png">
									<h4> Alhiane lahcen </h4>
								</div>
								<div class="user"><!-- Radio select new admin -->
									<input type="radio" value="1" id="user">
									<img src="layout/images/avatar/640455_avatar.png">
									<h4> Alhiane lahcen </h4>
								</div>	
							</div>					
						</div>
					</div>
				</div><!-- Start Admins Tab -->
				<div class="about each">about</div>
				<div class="policy each"></div>
				<div class="upp each"></div>
				<div class="sliders each"></div>
				<div class="con each"></div>
				<div class="seo each"></div>
				<div class="links each">links</div>
			</div>
		</div>
	</div>	
	<!-- End page Settings content -->

<?php include $tpl . 'footer.php'; ?>	