<?php
session_start();
require_once('connect.php');
$con = connect_to_db();

	 if (  !(isset($_SESSION['logged'])) ||  !(isset($_SESSION['fullname'])) || !((time() - $_SESSION['registered']) < 120 ))
		   echo "Nu sunteti logat, nu puteti vizualiza wishlist.";

	   
	   else 
	    {
		
		 $product_id_wishlist = $_GET['product_id_wishlist'];

		 $query = "delete from wishlist where product_id_wishlist='".$product_id_wishlist."' and username='".$_SESSION['username']."';";

		 $result= mysql_query($query);
		
		
  		 echo "<form name=\"wishlist_form\" action=\"show_details.php\" method=\"GET\"><input type=\"hidden\" name=\"product_id\" value=\"\"/>";
		
				require_once('connect.php');
				$con = connect_to_db();
				
				$query = "select wishlist.product_id, wishlist.product_id_wishlist, produse.titlu, produse.promotie, produse.pret_promotie, produse.pret, produse.imagelist from wishlist, produse where wishlist.username='".$_SESSION['username']."' AND wishlist.product_id = produse.product_id;";

				$result= mysql_query($query);
				
				$num_records = mysql_num_rows($result);
				
				if ($num_records == 0)
				 echo "Nu aveti produse in Wishlist.";
				else
				 {    
					  
					  echo "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\" width=\"100%\">";
						$i = 0;
						$total_produse = 0;
						$total = 0;
						while($row = mysql_fetch_array($result))
						{
							
							$imageList = $row['imagelist'];
							$imageArray = explode(";",$imageList);
							($i % 2 == 0)?$color = "#E9E9E9" : $color= "#FFFFFF";
							  
							  
							 echo "<tr bgcolor=\"".$color."\"><td nowrap=\"nowrap\" style=\"cursor:pointer;\" onClick=\"document.forms['wishlist_form'].product_id.value='".$row['product_id']."'; document.forms['wishlist_form'].submit()\">".$row['titlu']."</td>
									<td  align=\"center\" ><img src=\"../image_uploads/small/".$imageArray[0]."\" width=\"40\" height=\"50\"></td>
									<td nowrap=\"nowrap\"  align=\"center\">";
									if ($row['promotie']  == 'DA')
									 echo "<span style=\"color:#FF0000;\">Pret special : ".$row['pret_promotie']." RON</span>";
									 else
									echo "Pret : ".$row['pret']." RON ";
									
									
									
									echo "</td>
									
								   <td align=\"center\"><input type=\"button\" value=\"Sterge\" onClick=\"delete_refresh_wishlist('".$row['product_id_wishlist']."')\"></td>
								   </tr>";
							 
						 $i++;
						};
				
					echo "</table>";
					echo " </form>";
						
				  }; // sunt produse
	
			}; // este logat
		   mysql_close($con);



?>

