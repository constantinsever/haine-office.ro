<?php
session_start();

	if ( (isset($_SESSION['registered'])) &&  ((time() - $_SESSION['registered']) < 300 ))
	    $_SESSION['registered'] = time();
	else
	   die("Nu sunteti logat, nu puteti adauga produse");
	 	

		require_once('connect.php');
        $con = connect_to_db();

		$product_id = $_GET['product_id']; 
		$color = $_GET['color'];
		$size=$_GET['size'];

        
		$query = "select * from produse where  product_id ='".$product_id."' limit 1;";

		$result= mysql_query($query);
		$row = mysql_fetch_array($result);
		$num_records = mysql_num_rows($result);
   
		if ($num_records ==0 ) 
		  echo "Nu s-a gasit produsul, pentru adaugare in cos.";
		
		else
		{

          $username = $_SESSION['username'];
		  $quantity = "1";
		  $product_id_cart = date("dmyHis", time());

		  $order_status = "NOT CONFIRMED";
		   
 	    $query = "insert into shopping_cart (user_id, product_id, quantity, product_id_cart, size, color) VALUES ('".$username."', '".$product_id."', '".$quantity."', '".$product_id_cart."', '".$size."', '".$color."');";


            $result= mysql_query($query);
			
		 echo "Acest produs a fost adaugat in <span class=\"link_mouseOff\" onmouseover=\"className='link_mouseOn'\" onmouseout=\"className='link_mouseOff'\" onclick=\"document.location='shoppingCart.php'\">cosul de cumparaturi. </span>";	
			
   
		 		   
			
		   };
          
		  
  


  
 
 mysql_close($con);

?>

