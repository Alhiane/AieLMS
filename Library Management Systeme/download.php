<?php include 'init.php'; ?>
<?php 
    $id = (isset($_GET['book_id']) && is_numeric($_GET['book_id']) ? intval($_GET['book_id']) : 0 );

        $stmt2 = $con->prepare( "SELECT * FROM books WHERE ID = ?" );
        
        $stmt2->execute(array($id));

        $books = $stmt2->fetchAll();

        foreach ($books as $book) {
            $file= $book['file'];
            
            
            
           /* header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="'. $file .'"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($file);  
			*/
			if (file_exists($file)) {
            header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);

            $i = $book['Downloadconter'];
            $count1 = $i+1; 
            
            
            $stmt44 = $con->prepare( "UPDATE books SET Downloadconter = ? WHERE ID = ?" );
            $stmt44->execute(array($count1,$id));   
            exit;
            }       
        }

 ?>