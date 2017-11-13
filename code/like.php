<?php
session_start();

		require_once('connect.php');
        $con = connect_to_db();

		 $product_id = $_GET['product_id']; // !!! GET !!!

        
		 $query = "select * from produse where  product_id ='".$product_id."' limit 1;";

		 $result= mysql_query($query);
		 $row = mysql_fetch_array($result);
		 $num_records = mysql_num_rows($result);
   
		  if ($num_records ==0 ) 
		    echo "Nu s-a gasit produsul, pentru modificare rating.";
		
		 else
		  {
		    $i = $row['rating'] + 1;
  		    $query = "update produse set rating = '".$i."' where  product_id ='".$product_id."';";

            $result= mysql_query($query);
			
			
 		   $query = "select * from produse where  product_id ='".$product_id."' limit 1;";

		   $result= mysql_query($query);
		   $row = mysql_fetch_array($result);
		   
		   echo "Rating : ".$row['rating']." voturi";
		   
			
		   };
          
		  
  


  
 
 mysql_close($con);

?>


