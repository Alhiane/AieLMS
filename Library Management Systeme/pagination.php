<meta charset="utf-8">
<?php
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "liberary";

// Create database connection
$con = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
 

$per_page = 9;
$page = '';
$output = '';

if (isset($_POST['page'])) {
	$page = $_POST['page'];
} else {
	$page = 1;
}

$start_from = ($page - 1) * $per_page;

$query = "SELECT * FROM books WHERE aprove = 1 Order by ID DESC LIMIT $start_from, $per_page";

$result = mysqli_query($con, $query);	

while ($row = mysqli_fetch_array($result)) {

$output .= '
				<div class="h-book col-md-4">
					<meta charset="utf-8">
					<div class="img-avatar float-left">
						<img src="Admin/layout/images/books/'.$row['avatar'].'" class="rounded float-left" >
					</div>

					<div class="b-info">
						<a href="books.php?id='.$row['ID'].'&title='.str_replace(' ', '-', $row['title']).'"><h5>'.$row['title'].'</h5></a>
						<div class="detail">							
							<i class="fa fa-cloud-download"><span>'.$row['Downloadconter'].'</span></i>	
							
							<i class="fa fa-user"> <span>'.$row['author'].'</span></i>

							<i class="fa fa-language"> <span>'.$row['lang'].'</span></i>
							
							<i class="fa fa-tags">'.$row['tags'].'</i>
						</div>
					</div>

				</div>
				<div class="clearfix"></div>
';
}


$page_query = "SELECT * FROM books WHERE aprove = 1 Order by ID DESC";
$page_result = mysqli_query($con, $page_query);
$total_records = mysqli_num_rows($page_result);
$total_page = ceil($total_records/$per_page);
$output .= "<div class='pag'>";
for ($i=1; $i <= $total_page; $i++) { 
	$output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; boder:1px solid #ccc;' id='".$i."' >".$i."</span>";
}
$output .= "</div>";
echo $output;

