<?php
session_start();

		require_once('connect.php');
        $con = connect_to_db();

		 $username = $_GET['username']; 
		 $password = $_GET['password']; 
        
		 $query = "select * from ho_users where username='".$username."' and password='".$password."' limit 1;";

		 $result= mysql_query($query);
		 $row = mysql_fetch_array($result);
		 $num_records = mysql_num_rows($result);
   
		  if ($num_records ==0 ) 
		    echo "bad password"; // stringul va fi inter[pretat de AjAx.
		
		 else
		  {
		  
		  
		   $_SESSION['logged'] = 1;
		   $_SESSION['username'] = $row['username'];
		   $_SESSION['group'] = $row['user_group'];
		   $_SESSION['fullname'] = $row['fullname'];
 	       $_SESSION['address'] = $row['address'];
		   $_SESSION['phone'] = $row['phone'];
		   $_SESSION['email'] = $row['email'];
		   $_SESSION['registered'] = time();
		  
           ?>
		   <form name="requiredAction" action="addModifyProduct.php" method="GET">
			      <table width="100%" border="0" cellpadding="3" cellspacing="0">
			          <tr><td class="bold">Salut, <?php echo $_SESSION['username'] ?> !</td></tr>
			          <tr><td nowrap="nowrap"><a href="javascript: void(0)"  onclick="document.location='shoppingCart.php'" >Cosul de cumparaturi</a><br />
                          <a href="javascript: void(0)" onclick="document.location='wishlist.php'"> Wishlist</a><br />
                          <a href="javascript: void(0)" onclick="document.location='showOrders.php'">Istoric comenzi</a><br />	
						  <a href="javascript: void(0)" onclick="showProducts(101,1)">Credite disponibile</a><br />	
			            <a href="javascript: void(0)" onclick="showProducts(101,1)">Gestiune cont</a><br />	
				 
				 <?php
 				 if ( (isset($_SESSION['registered'])) && ($_SESSION['group'] == "administrators"))
				   {
				    echo "<hr>";
				    echo "<a href=\"javascript: void(0)\" onclick=\"document.location='manageCategories.php'\" >Gestiune produse</a><br>"; 
				    echo "<a href=\"javascript: void(0)\" onclick=\"document.location='userManagement.php'\" >Gestionare utilizatori</a><br>"; 
				   };	
		 
				 ?>
			            <hr />
				        <a href="javascript: void(0)" onclick="document.location='logout.php'">Iesire din cont</a><br />		   
			            </td></tr>
			          </table>	
			   <input type="hidden" name="action" id="action"  value="0" />
			        <input type="hidden" name="product_id" id="product_id"  value="0" />
			        </form>	 	
			 <?PHP
			  		 

		   
		   };
 
 mysql_close($con);

?>


