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


<SCRIPT language="JavaScript" SRC="product_functions.js"></SCRIPT> 
<SCRIPT language="JavaScript" SRC="accountScripts.js"></SCRIPT> 


</head>

<body>

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
          <td align="center" valign="top"><p>&nbsp;</p>
          <table width="90%" border="1" cellpadding="10" cellspacing="0" bordercolor="#CCCCCC" >
            <tr>
              <td align="left" class="bold" >Finalizare  comanda </td>
            </tr>
            <tr>
              <td align="left" class="arial" >
                  <?php
	  if (  !(isset($_SESSION['logged'])) ||  !(isset($_SESSION['fullname'])) || !((time() - $_SESSION['registered']) < 300 ))
		   echo ("Nu sunteti logat, nu puteti vizualiza cosul de cumparaturi.");

	   
	   else
	    {
		
		
		$query = "select shopping_cart.product_id, shopping_cart.quantity, shopping_cart.size, shopping_cart.color, produse.titlu, produse.imagelist, produse.pret, produse.promotie, produse.pret_promotie, produse.stoc from shopping_cart, produse where shopping_cart.user_id='".$_SESSION['username']."' AND shopping_cart.product_id = produse.product_id;";
	  $res = mysql_query($query);
	  if (mysql_num_rows($res) == 0)
	   echo "Cosul de cumparaturi este acum gol, va rugam adaugati produse in cosul de cumparaturi.";
	  else
	  {
	   
				
				  $order_id = date("dmyHis", time());
				  echo "<form name=\"placeOrder_form\" action=\"placeOrder_exec.php\" method=\"POST\">
						<input type=\"hidden\" name=\"hidden_order_id\" value=\"".$order_id."\"/>";
					
					echo "<table border=\"0\" width=\"100%\" cellpadding=\"5\" cellspacing=\"0\" >";
						  $color = 0;
						  $pret_final = 0;
						  $i = 1;
						  echo " <tr> <td nowrap=\"nowrap\" colspan=\"4\" align=\"center\">
						   <table cellpadding=\"3\" width=\"100%\" cellspacing=\"0\">
						   <tr> <td nowrap=\"nowrap\" colspan=\"5\" class=\"bold\">Sumar comanda numarul : ".$order_id." </td></tr>";
							while ($product_row = mysql_fetch_array($res))				    
							 {
							 $i ++;
							  $imageList = $product_row['imagelist'];
							  $imageArray = explode(";",$imageList);
							  ($i % 2 == 0)?$color = "#E9E9E9" : $color= "#FFFFFF";
							  echo "<tr bgcolor=\"".$color."\">
								 <td><img src=\"../image_uploads/small/".$imageArray[0]."\" width=\"60\" height=\"70\" title=\"".$product_row['titlu']."\" ></td>
								  <td>Marime selectata : ".$product_row['size']."<br><br>
									  Culoare selectata : ".$product_row['color']."
								  </td>   
								  <td>Marime selectata : ".$product_row['size']."<br><br>";
								  if ($product_row['promotie']  == 'DA')
								   {
									echo "<span style=\"color:#FF0000;\">Pret unitar special : ".$product_row['pret_promotie']." RON</span>";
									$pret = $product_row['pret_promotie'];
									}
								  else
									{
									 echo "Pret unitar : ".$product_row['pret']." RON ";
									 $pret = $product_row['pret'];
									 };
								   echo "</td><td>";
								 echo "Cantitate : ".$product_row['quantity']."</td>
								  <td align=\"center\">Pret : ".intval($pret)*intval($product_row['quantity'])." RON</td>
								</tr>";
								$pret_final = $pret_final + intval($pret)*intval($product_row['quantity']);
							  };
						   
						   echo "<tr>
								  <td colspan=\"4\" align=\"right\" class=\"bold\">&nbsp;</td>
								   <td  align=\"center\" class=\"bold\">Total : ".$pret_final." RON</td>
								 </tr>
						   </table>";
						  
						  echo "
						  <tr> <td nowrap=\"nowrap\" colspan=\"4\"><hr></td></tr>
						  <tr> <td nowrap=\"nowrap\" colspan=\"4\">Verificati datele de livrare, faceti corecturile necesare, daca este cazul.</td></tr>
						  <tr> <td nowrap=\"nowrap\" colspan=\"2\">Nume si prenume : </td><td><input type=\"text\" value=\"".$_SESSION['fullname']."\" class=\"box_400\" name=\"nume_prenume\"></td></tr>
						  <tr> <td nowrap=\"nowrap\" colspan=\"2\">Adresa : </td><td><input type=\"text\" value=\"".$_SESSION['address']."\" class=\"box_400\" name=\"address\"></td></tr>
						  <tr> <td nowrap=\"nowrap\" colspan=\"2\">Numar de telefon : </td><td><input type=\"text\" value=\"".$_SESSION['phone']."\" class=\"box_400\" name=\"phone\"></td></tr>
						  <tr> <td nowrap=\"nowrap\" colspan=\"2\">Adresa e-mail : </td><td><input type=\"text\" value=\"".$_SESSION['email']."\" class=\"box_400\" name=\"email\"></td></tr>
						   <tr> <td nowrap=\"nowrap\" colspan=\"2\" valign=\"top\">Detalii suplimentare : </td><td><textarea rows=\"5\" class=\"box_400\" value=\"\" name=\"observatii_user\"></textarea></td></tr>";
						  
			
					 echo "<tr><td colspan=\"3\" align=\"center\"><input type=\"button\" value=\"Finalizeaza comanda\" class=\"box_200\" onClick=\"place_order()\"></td>
						 </tr>";	  
					
					
					
					
					echo "</table>";
				  
				  echo " </form>";
				
				 };
			  
	  };
	  
	  ?>
              </td>
            </tr>
          </table></td>
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
                  <input type="hidden" name="product_id2" id="product_id"/>
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
							
							echo " RON !\" onClick=\"document.forms['bestSeller'].product_id_vanzari.value='".$row2['product_id']."'; document.forms['bestSeller'].submit()\" style=\"cursor:pointer\"/><br><br>";
 
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
              <td align="center" nowrap="nowrap"  class="link_mouseOff" onclick="showProducts(101,1)" onmouseover="className='link_mouseOn'" onmouseout="className='link_mouseOff'">Intrebari frecvente </td>
              <td align="center" nowrap="nowrap"  class="link_mouseOff" onclick="showProducts(101,1)" onmouseover="className='link_mouseOn'" onmouseout="className='link_mouseOff'">Reguli de functionare </td>
              <td align="center" nowrap="nowrap"  class="link_mouseOff" onclick="showProducts(101,1)" onmouseover="className='link_mouseOn'" onmouseout="className='link_mouseOff'">Distributie </td>
              <td align="center" nowrap="nowrap"  class="link_mouseOff" onclick="showProducts(101,1)" onmouseover="className='link_mouseOn'" onmouseout="className='link_mouseOff'">Campanii umanitare </td>
              <td align="center" nowrap="nowrap"  class="link_mouseOff" onclick="showProducts(101,1)" onmouseover="className='link_mouseOn'" onmouseout="className='link_mouseOff'">Contact</td>
            </tr>
          </table></td>
          <td align="center">&nbsp;</td>
          </tr>
        <tr>
          <td align="left" valign="middle" >&nbsp;</td>
          <td align="center"><img src="../images/spacers/spacer_1.jpg" width="800" height="1" /></td>
          <td align="center"><img src="../images/spacers/spacer_1.jpg" width="150" height="1" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>


</body>
</html>
