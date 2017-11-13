<?php
session_start();

	if (isset($_SESSION['logged']) && ((time() - $_SESSION['registered']) < 300 ) )
	    $_SESSION['registered'] = time();
	else
	   die("Nu sunteti logat, nu puteti adauga produse la wishlist");
	 	

		require_once('connect.php');
        $con = connect_to_db();

		$product_id = $_GET['product_id']; // !!! GET !!!

        
		$query = "select * from produse where  product_id ='".$product_id."' limit 1;";

		$result= mysql_query($query);
		$row = mysql_fetch_array($result);
		$num_records = mysql_num_rows($result);
   
		if ($num_records ==0 ) 
		  echo "Nu s-a gasit produsul, pentru adaugare la wishlist.";
		
		else
		{
		  $product_id_wishlist = date("dmyHis", time());	
          $username = $_SESSION['username'];
	      $query = "insert into wishlist (username, product_id, product_id_wishlist) VALUES ('".$username."', '".$product_id."', '".$product_id_wishlist."');";


            $result= mysql_query($query);
			
		 echo "Acest produs a fost adaugat in  <a href=\"javascript: void(0)\"  onclick=\"document.location='wishlist.php'\" >Wishlist. </span>";	
			
   
		 		   
			
		   };
          
		  
  


  
 
 mysql_close($con);

?>

