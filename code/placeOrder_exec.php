<?php
session_start();
require_once('connect.php');

$con = connect_to_db();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Haine Office - Eleganta la un click distanta</title>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:25px;
	top:26px;
	width:836px;
	height:1018px;
	z-index:1;
}
-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#Layer2 {
	position:absolute;
	left:232px;
	top:484px;
	width:280px;
	height:87px;
	z-index:2;
}
.style1 {font-size: 14px}
-->
</style>

<script>
function addModifyProduct(action, product_id)
 {
	document.getElementById('action').value=action;
	document.getElementById('product_id').value=product_id;
	document.forms['requiredAction'].submit();
 };

</script>


<SCRIPT language="JavaScript" SRC="product_functions.js"></SCRIPT> 
<SCRIPT language="JavaScript" SRC="accountScripts.js"></SCRIPT> 


</head>

<body >
<div id="Layer1" >
  <table  border="0" cellpadding="0" cellspacing="0" class="rounded_corner">
    <tr>
      <td>
	  <table  border="0" cellpadding="1" cellspacing="5">
      
        <tr>
          <td align="left" valign="top" ><table border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td colspan="3" align="center"><a href="index.php"><img src="../images/icons/ho.jpg" width="200" height="57" border="0" /></a></td>
            </tr>
            <tr>
              <td colspan="3" align="left" valign="top" nowrap="nowrap" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="left" valign="top" nowrap="nowrap"><form action="browse_products.php" method="get" name="select_category" id="select_category">
                  <?php

				  $result= mysql_query("select * from categories where childOf='root';");// extrag parintii
				  $num_records = mysql_num_rows($result);
				 
			
				 
			      
  			      if ($num_records != 0)
				  {
				   echo "<a href=\"javascript: void(0)\" onclick=\"showProducts('root',1)\">Toate produsele</a><br>";
				   while($parinti = mysql_fetch_array($result))
				   {
					echo "<a  href=\"javascript: void(0)\" onclick=\"showProducts(".$parinti['category_id'].",1)\">&nbsp;&nbsp;".$parinti['category_name']."</a><br>";

					 $result1= mysql_query("select * from categories where childOf = '".$parinti['category_id']."';");// extrag fii pentru fiecate parinte
					 $num_records1 = mysql_num_rows($result1);
					 if ($num_records1 != 0)
						 while($fii = mysql_fetch_array($result1))
						 {
						  echo "<a href=\"javascript: void(0)\" onclick=\"showProducts(".$fii['category_id'].",1)\">&nbsp;&nbsp;&nbsp;&nbsp;".$fii['category_name']."</a><br>";
						   $result2= mysql_query("select * from categories where childOf = '".$fii['category_id']."';");// extrag nepotii pentru fiecate parinte
						   $num_records2 = mysql_num_rows($result2);
						   if ($num_records2 != 0)
 						   while($nepoti = mysql_fetch_array($result2))
							{
							 echo "<a href=\"javascript: void(0)\" onclick=\"showProducts(".$nepoti['category_id'].",1)\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nepoti['category_name']."</a><br>";
							 };
						   
						  };
					  }; //while
					 }; //if
					
			
				  ?>
                  <input name="hiddenCategory" type="hidden" value="" />
                  <input name="hiddenIndex" type="hidden" value="" />
              </form></td>
            </tr>
            <tr>
              <td colspan="3" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
            </tr>
            <tr>
              <form action="search.php" method="get" name="search_form" id="search_form">
                <td align="center" class="bold">Cautare</td>
                <td align="center"><input name="searchCriteria" type="text" class="box_120" id="searchCriteria" /></td>
                <td align="right" valign="middle"><img src="../images/icons/search.png" onclick="searchProducts(document.search_form.searchCriteria.value,1)" title="Cautare" /></td>
                <input type="hidden" name="searchIndex" id="searchIndex" value="1"/>
              </form>
            </tr>
            <tr>
              <td colspan="3" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
            </tr>
            <tr>
              <td class="bold">News </td>
              <td align="center"><input name="emailNewsletter" type="text" class="box_120" id="emailNewsletter" value="adresa email ..." onclick="this.value=''"/></td>
              <td align="right"><img src="../images/icons/submit.png" width="22" height="22" onclick="abonareNewsletter()" title="Abonare"/></td>
            </tr>
            <tr>
              <td colspan="3" align="right" style="background-repeat:repeat-x"><div class="arial" id="aaa"></div></td>
            </tr>
            <tr>
              <td colspan="3" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" align="center" class="bold">Alte produse de vizitat acum </td>
            </tr>
            <tr>
              <td colspan="3" align="center"><form action="show_details.php" method="get" name="showPresent" id="showPresent">
                  <input type="hidden" name="product_id" />
                  <?php
				
				$query1 = "select * from produse where cadou='DA';";
				
				$result1= mysql_query($query1);
				$num_records = mysql_num_rows($result1);
				
				if ($num_records != 0 ) 

				{
					$index1 = rand(0,$num_records-1);
					$i = -1;
					while ($row1 = mysql_fetch_array($result1))
					 {
					 $i++;


					  if ( ($index1 == $i) || ($index1 == $i+1))
					   {
							$imageList = $row1['imagelist'];
							$imageArray = explode(";",$imageList);
							$image = "../image_uploads/small/".$imageArray[0];
							echo " <img src=\"".$image."\" onClick=\"document.forms['showPresent'].product_id.value='".$row1['product_id']."'; document.forms['showPresent'].submit()\" style=\"cursor:pointer\"/>&nbsp;";
									  
						}
					 };
				 };
				  			
			?>
              </form></td>
            </tr>
          </table></td>
          <td align="center" valign="top">

		    <p>&nbsp;</p>
		    <table width="90%" border="1" cellpadding="10" cellspacing="0" bordercolor="#CCCCCC" >
              <tr>
                <td align="left" class="bold" >Finalizare  comanda </td>
              </tr>
              <tr>
                <td align="left" class="arial" ><?php

       if (  !(isset($_SESSION['logged'])) ||  !(isset($_SESSION['fullname'])) || !((time() - $_SESSION['registered']) < 300 ))
		   echo ("Nu sunteti logat, nu puteti vizualiza cosul de cumparaturi.");
       
	   else
	    {
		 $order_id = $_POST['hidden_order_id'];
		 if (mysql_num_rows(mysql_query("select * from orders where order_id='".$order_id."'")) != 0)
		  echo "Comanda ".$order_id." a fost lansata deja, si se afla in procesare.";

		 else // totul OK, se proceseaza comanda
				{
				
				  $date_time = date("d/m/Y  H:i:s", time());
				  $observatii_user = $_POST['observatii_user']; 
				  $message = "Comanda dvs. a fost plasata cu succes. <br> Aveti mai jos detaliile acestei comenzi. Pastrati aceste informatii.\n<br><br> ";
				  $message = $message . "Numar comanda : ".$order_id ." <br>";
				  $message = $message . "Data si ora comanda : ".$date_time." <br>";
				  $message = $message . "Nume si prenume : ".$_POST['nume_prenume']."<br>";
				  $message = $message . "Adresa : ".$_POST['address']."<br>";
				  $message = $message . "Adresa email : ".$_POST['email']."<br>";
				  $message = $message . "Numar telefon : ".$_POST['phone']."<br>";
				  $message = $message . "Observatii suplimentare : ".$_POST['observatii_user']."<br>";
				  
				  
				  echo $message;
				
					$query = "select shopping_cart.product_id, shopping_cart.quantity, shopping_cart.size, shopping_cart.color, produse.titlu, produse.imagelist, produse.pret, produse.promotie, produse.pret_promotie, produse.stoc from shopping_cart, produse where shopping_cart.user_id='".$_SESSION['username']."' AND shopping_cart.product_id = produse.product_id;";
					$res = mysql_query($query);
				  while ($product_row = mysql_fetch_array($res))	
					{
					
					 $q = "insert into orders(order_id,order_status,username, observatii_system, product_id, quantity, size,color, pret, pret_promotie, nume_prenume, adresa, telefon, email,observatii_user, date_time) ";
					 $q = $q. "values('".$order_id."', 'processing', '".$_SESSION['username']."', 'no problem', '".$product_row['product_id']."', '".$product_row['quantity']."', '".$product_row['size']."', '".$product_row['color']."', '".$product_row['pret']."', '".$product_row['pret_promotie']."', '".$_POST['nume_prenume']."',  '".$_POST['address']."', '".$_POST['phone']."', '".$_POST['email']."', '".$_POST['observatii_user']."', '".$date_time."');";
					 
					 mysql_query($q);
					 };
			  
			  
			  
			  
			  
			  
				  $to = $_POST['email'];
				  $subject = "Comanda Haine-Office #".$order_id;
				  $message_mail = "<html> <body bgcolor=\"#CCCCCC\"> ".$message."</body> </html> ";
		
				 //options to send to cc+bcc 
				 //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
				  //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
				 
				  $from = "office@haine-office.ro";
				  $headers  = "From: $from\r\n"; 
				  
				  $headers .= "Content-type: text/html\r\n"; 
				  
				  //mail($to,$subject,$message_mail,$headers);
		
				  echo "O copie a sumarului comenzii a fost trimisa la adresa ".$_POST['email'];
			   };// daca este logat
			   
			 mysql_query("delete from shopping_cart where user_id='".$_SESSION['username']."';"); 
			};   // comanda OK
		

?></td>
              </tr>
            </table>		    <p>&nbsp;  </p></td>
          <td align="left" valign="top"><table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
            </tr>
            <tr>
              <td><div id="login_php_output" class="rounded_corner">
                  <?php
			   if ( (!isset($_SESSION['registered'])) || ((time() - $_SESSION['registered']) > 300 ))
				{ ?>
                  <form name="login_form" id="login_form">
                    <table border="0" cellpadding="3" cellspacing="0" bordercolor="#E9E9E9" >
                      <tr>
                        <td colspan="2" align="center" nowrap="nowrap" ><input name="username" type="text" class="box_120" id="username" /></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" nowrap="nowrap" ><input name="password" type="password" class="box_120" id="password" /></td>
                      </tr>
                      <tr>
                        <td align="center" nowrap="nowrap" ><a href="javascript: void(0)" onclick="login()">Intra in cont</a></td>
                        <td align="center" nowrap="nowrap" ><a href="javascript: void(0)" onclick="document.location='createAccount.php'">Cont nou</a></td>
                      </tr>
                    </table>
                  </form>
                <?php
				  }
				  else
				   { 
				   ?>
                  <table width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                      <td class="bold">Salut, <?php echo $_SESSION['username'] ?> !</td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap"><a href="javascript: void(0)"  onclick="document.location='shoppingCart.php'" >Cosul de cumparaturi</a><br />
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
                      </td>
                    </tr>
                  </table>
                <?PHP
			   $_SESSION['registered'] = time();
				    };
				  ?>
              </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><form action="show_details.php" method="get" name="bestSeller" id="bestSeller">
                <input type="hidden" name="product_id id="product_id" />
                <table border="0" cellspacing="0" width="100%" bordercolor="#E9E9E9" class="rounded_corner">
                  <tr>
                    <td class="bold" align="center" > Bestsellers</td>
                  </tr>
                  <tr>
                    <td align="center"><?php
			
				$result2= mysql_query("select * from produse order by vanzari DESC limit 2;");
						
			     while ($row2 = mysql_fetch_array($result2))
					 {
                            $imageList2 = $row2['imagelist'];
							$imageArray2 = explode(";",$imageList2);
							$image2 = "../image_uploads/small/".$imageArray2[0];
							echo "<img src=\"".$image2."\" title=\"".$row2['titlu']." - ";
							 if ($row2['promotie'] == 'DA')
							  echo $row2['pret_promotie'];
							 else
   						     echo $row2['pret'];
							
							echo " RON !\" onClick=\"document.forms['bestSeller'].product_id.value='".$row2['product_id']."'; document.forms['bestSeller'].submit()\" style=\"cursor:pointer\"/><br><br>";
 
					 };
					 mysql_close($con);
			?>
                    </td>
                  </tr>
                </table>
              </form></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        
        
        <tr>
          <td align="left" valign="middle" >&nbsp;</td>
          <td align="center"><table width="90%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" nowrap="nowrap"><a href="javascript: void(0)" onclick="document.location='logout.php'">Intrebari frecvente </a></td>
              <td align="center" nowrap="nowrap"  ><a href="javascript: void(0)" onclick="document.location='logout.php'">Reguli de functionare</a> </td>
              <td align="center" nowrap="nowrap" ><a href="javascript: void(0)" onclick="document.location='logout.php'">Distributie</a> </td>
              <td align="center" nowrap="nowrap"  ><a href="javascript: void(0)" onclick="document.location='logout.php'">Campanii umanitare</a> </td>
              <td align="center" nowrap="nowrap"  ><a href="javascript: void(0)" onclick="document.location='logout.php'">Contact</a></td>
            </tr>
          </table></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" >&nbsp; </td>
          <td align="center"><img src="../images/spacers/spacer_1.jpg " width="800" height="1" /></td>
          <td align="center"><img src="../images/spacers/spacer_1.jpg " width="150" height="1" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>



</body>
</html>
