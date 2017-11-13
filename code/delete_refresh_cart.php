<?php
session_start();
		
require_once('connect.php');
$con = connect_to_db();


function stocSuficient($pid, $quant)
{
 $q = mysql_query("select * from shopping_cart where product_id_cart='".$pid."'");
 $s = mysql_fetch_array($q);
$q =  mysql_query("select * from produse where product_id='".$s['product_id']."'");
$s = mysql_fetch_array($q);
$stoc = $s['stoc'];

if ($stoc > $quant)
 return 1;
 else 
 return 0;
 
};



	if (isset($_SESSION['logged']) && isset($_SESSION['fullname']) && ((time() - $_SESSION['registered']) < 300 ) )
	    $_SESSION['registered'] = time();
	else
	   die("Nu sunteti logat, nu puteti adauga/sterge produse");
	 	

		require_once('connect.php');
        $con = connect_to_db();
		 $quantity = $_GET['quantity'];
		 $product_id_cart = $_GET['product_id_cart']; 
		 $action = $_GET['action'];
		 $color = $_GET['color'];
		 $size= $_GET['size'];
		 

		 if ($action == 1) // refresh
		  {
		     if (stocSuficient($product_id_cart,$quantity))
 			  mysql_query("update shopping_cart set quantity='".$quantity."', color='".$color."', size='".$size."' where product_id_cart ='".$product_id_cart."' and user_id ='".$_SESSION['username']."';");
			}
		 else //delete	
		  {	 
		    mysql_query("delete from shopping_cart where product_id_cart ='".$product_id_cart."' and user_id ='".$_SESSION['username']."';");		          
  		   };




	
  		  echo "<form name=\"show_details\" action=\"show_details.php\" method=\"GET\"><input type=\"hidden\" name=\"product_id\" value=\"\"/></form>";
	  

			
			$query = "select shopping_cart.product_id, shopping_cart.quantity, shopping_cart.product_id_cart, produse.titlu, produse.imagelist, produse.pret, produse.stoc from shopping_cart, produse where shopping_cart.user_id='".$_SESSION['username']."' AND shopping_cart.product_id = produse.product_id;";
			
			$result= mysql_query($query);
			
			$num_records = mysql_num_rows($result);
				if ($num_records == 0)
				 die("Nu aveti produse in cosul de cumparaturi.");
			
			
			echo "<form name=\"shopping_cart_form\" action=\"show_details.php\" method=\"GET\"><input type=\"hidden\" name=\"product_id\" value=\"\"/>";
	
			require_once('connect.php');
			$con = connect_to_db();
			
			$query = "select shopping_cart.product_id, shopping_cart.quantity, shopping_cart.product_id_cart, shopping_cart.size, shopping_cart.color, produse.titlu, produse.imagelist, produse.size_list, produse.color_list, produse.pret, produse.promotie, produse.pret_promotie, produse.stoc from shopping_cart, produse where shopping_cart.user_id='".$_SESSION['username']."' AND shopping_cart.product_id = produse.product_id;";
	
			$result= mysql_query($query);
			
			$num_records = mysql_num_rows($result);
 		    if ($num_records != 0)
			{
			
				echo "<table border=\"0\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">";
				$i = 0;
				$total_produse = 0;
				$total = 0;
				while($row = mysql_fetch_array($result)){
					
				$imageList = $row['imagelist'];
				$imageArray = explode(";",$imageList);
				($i % 2 == 0)?$color = "#E9E9E9" : $color= "#FFFFFF";
				  
				  
				 echo "<tr bgcolor=\"".$color."\"><td nowrap=\"nowrap\"><div style=\"cursor:pointer\" onClick=\"document.forms['shopping_cart_form'].product_id.value='".$row['product_id']."'; document.forms['shopping_cart_form'].submit()\"><img src=\"../image_uploads/small/".$imageArray[0]."\" width=\"60\" height=\"70\" title=\"".$row['titlu']."\" ></td>
				       <td nowrap=\"nowrap\"  align=\"left\"> Marime : ";
					     $sizeList = rtrim($row['size_list']);
						 $sizeArray= explode(",",$sizeList);
						  echo "<select name=\"size_list\" id=\"size_list_".$row['product_id_cart']."\" class=\"box_120\">";
						   foreach($sizeArray as $size)
						    {
							 echo "<option value=\"".$size."\" ";
							  if ($size == $row['size'])
							   echo "selected";
							 echo ">".$size."</option>";
							 };
						  echo "</select> <br><br>";

					   
					     $colorList = rtrim($row['color_list']);
						 $colorArray= explode(",",$colorList);
						  echo "Culoare : <select name=\"color_list\" id=\"color_list_".$row['product_id_cart']."\" class=\"box_120\">";
						   foreach($colorArray as $color)
						    {
							 echo "<option value=\"".$color."\" ";
							  if ($color == $row['color'])
							   echo "selected";
							 echo ">".$color."</option>";
							 };
						  echo "</select> <br>";

					    
						 if ( $product_id_cart == $row['product_id_cart'] ) 
			              { if (!stocSuficient($product_id_cart,$quantity))
 						    echo "<span style=\"color:#FF0000; font-weight:bold\">Comanda la furnizor<span>"; 
						   else
						    echo "<span style=\"color:#006633; font-weight:bold\">Livrare din stoc<span>";
						  }
						  else
						    echo "<span style=\"color:#006633; font-weight:bold\">Livrare din stoc<span>";
						  
					     echo "</td>";
					   
					     echo " <td nowrap=\"nowrap\" align=\"left\">";
					    if ($row['promotie']  == 'DA')
						 echo "<span style=\"color:#FF0000;\">Pret special : ".$row['pret_promotie']." RON</span>";
						 else
						echo "Pret : ".$row['pret']." RON ";
						echo "<br> <br> Cantitate : <input type=\"text\"  id=\"quantity_".$row['product_id_cart']."\" value=\"".$row['quantity']."\" maxlength=\"2\" size=\"2\"><br>
					   </td>
					   <td align=\"center\">
					   <input type=\"button\"  class=\"box_120\" name=\"refresh\" value=\"Refresh\" onClick=\"delete_refresh_cart(1,'".$row['product_id_cart']."')\"><br><br>
					   <input type=\"button\"  class=\"box_120\" value=\"Sterge\" onClick=\"delete_refresh_cart(2,'".$row['product_id_cart']."')\"></td>
				 </tr>";
				 $total_produse = $total_produse + ($row['pret'] * $row['quantity']);
				 $i++;
			 
			 
			}
		
			 echo "<tr><td colspan=\"4\"><hr></td></tr>";
			 echo "<tr><td colspan=\"2\" ></td><td align=\"left\" class=\"bold\" > &nbsp; &nbsp; &nbsp;Pret total :</td>
			          <td class=\"bold\" align=\"center\">".$total_produse." RON</td>
				 </tr>";	  
		
             echo "<tr><td colspan=\"4\"><hr></td></tr>";
			 echo "<tr><td colspan=\"2\"></td><td colspan=\"2\" align=\"center\"><input type=\"button\" value=\"Finalizeaza comanda\" onClick=\"document.location='placeOrder.php'\"></td></tr>";	  
		
			
			
			echo "</table>";
		  
		  echo " </form>";
			
			
	  

 
 };
 
 
 mysql_close($con);

?>

