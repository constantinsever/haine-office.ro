<?php
session_start();
require_once('connect.php');

$con = connect_to_db();


  $product_id = $_GET['product_id'];

   $result= mysql_query("select * from produse where product_id = '".$product_id."' limit 1;");
  if (mysql_num_rows($result) == 0)
   die ("no records found");
   
   $row = mysql_fetch_array($result);
   $vizualizari = $row['vizualizari'] + 1;
   
   $query1 = "update produse set vizualizari='".$vizualizari."' where  product_id = '".$product_id."';";
   mysql_query($query1);
   
   
   $imageArray = explode(";",$row['imagelist']);
   
   $imageCount = count($imageArray);

   ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "DTD/xhtml1-strict.dtd">
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
<script type="text/javascript" src="lightbox/js/prototype.js"></script>
<script type="text/javascript" src="lightbox/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="lightbox/js/lightbox.js"></script>
<link rel="stylesheet" href="lightbox/css/lightbox.css" type="text/css" media="screen" />

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
              <td colspan="3" align="center"><a href="index.php"><img src="../images/icons/ho.jpg" width="200" height="58" border="0" /></a></td>
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
                  
                  <input type="hidden" name="product_id" id="product_id"/>
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
							$imageList1 = $row1['imagelist'];
							$imageArray1 = explode(";",$imageList1);
							$image = "../image_uploads/small/".$imageArray1[0];
							echo " <img src=\"".$image."\" onClick=\"document.forms['showPresent'].product_id.value='".$row1['product_id']."'; document.forms['showPresent'].submit()\" style=\"cursor:pointer\"/>&nbsp;";
									  
						}
					 };
				 };
				  			
			?>
              </form></td>
            </tr>
          </table></td>
          <td align="center" valign="top"><table width="85%" border="0" cellpadding="5" cellspacing="5" class="rounded_corner">
            <tr>
              <td colspan="3" align="left" class="bold" ><span style="font-size:14px"> <?php echo $row['titlu'], "</span><br>  <span class=\"bold\">ID produs : ", $row['product_id'] ?></span> 
			  <input name="product_id_main" type="hidden" id="product_id_main" value="<?php echo $row['product_id'] ?>"/></td>
            </tr>
            <tr>
              <td colspan="3" align="left" class="arial"><span  style="text-align:justify"><?php echo $row['descriere'] ?></span></td>
            </tr>
            <tr>
              <td colspan="3" align="center" class="arial"></td>
            </tr>
            <tr>
              <td colspan="3" align="center" nowrap="nowrap"><table border="0" cellspacing="5">
                  <tr>
                    <?php
						   $k = 1;
                 
						 for ($i = 0; $i <= $imageCount-1; $i++)
						  {
						   if ($k <= 6)
							 {
							  echo "<td><a href=\"../image_uploads/".$imageArray[$i]."\"  rel=\"lightbox[product]\" title=\"".$row['titlu']."\"><img src=\"../image_uploads/small/".$imageArray[$i]."\" ></a></td>";
							  $k++;
							  }
							else
							 {
							  echo "</tr><tr>";
							  echo "<td><a href=\"../image_uploads/".$imageArray[$i]."\" rel=\"lightbox[product]\" ><img src=\"../image_uploads/small/".$imageArray[$i]."\" ></a></td>";
							  $k = 1;
							  };
						   };
						  for ($j = $k; $j < 5; $j++)
						  echo "<td></td>"; 
						  ?>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="3" align="center" nowrap="nowrap" class="arial">&nbsp;</td>
            </tr>
            <tr>
              <td width="21%" align="center" nowrap="nowrap" class="arial">Marimi disponibile :</td>
              <td width="29%" align="left" nowrap="nowrap" class="arial"><select name="size_list" id="size_list" class="box_120">
                  <?php
					   $sizeArray = explode(",",$row['size_list']);
		       	       $sizeCount = count($sizeArray);
					    for ($i = 0; $i < $sizeCount; $i++)
						 echo "<option value=\"".$sizeArray[$i]."\">".$sizeArray[$i]."</option>";
					   
					   ?>
              </select></td>
              <td width="50%" align="left" nowrap="nowrap" class="arial"><span class="bold">
                Disponibilitate : <?php if  ($row['stoc'] > 0 ) echo "<span style=\"color:#006633; font-weight:bold\">Livrare directa din stoc<span> ";
					         else
					        echo "<span style=\"color:#FF0000; font-weight:bold\">Livrare la comanda<span> ";
						 ?>
              </span></td>
              </tr>
            <tr>
              <td align="center" nowrap="nowrap" class="arial">Culori disponibile : </td>
              <td align="left" nowrap="nowrap" class="arial"><select name="color_list" id="color_list" class="box_120">
                <?php
					   $colorArray = explode(",",$row['color_list']);
		       	       $colorCount = count($colorArray);
					    for ($i = 0; $i < $colorCount; $i++)
						 echo "<option value=\"".$colorArray[$i]."\">".$colorArray[$i]."</option>";
					   
					   ?>
              </select></td>
              <td align="left" nowrap="nowrap" class="arial"><span class="bold">
                Pret: &nbsp;
                    <?php
					   if ($row['promotie'] == "DA")
						 echo "<span  style=\"text-decoration:line-through\">&nbsp;".$row['pret']."&nbsp;RON&nbsp;</span>&nbsp;".$row['pret_promotie']."&nbsp;RON&nbsp;</span>&nbsp;";
						else
						  echo "&nbsp;".$row['pret']."&nbsp;RON&nbsp;";
						?>
              </span></td>
            </tr>
            <tr>
              <td colspan="3" nowrap="nowrap" class="arial"><hr /></td>
            </tr>
            <tr>
              <td colspan="3" align="center" nowrap="nowrap" class="arial"><table width="80%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>Vizualizari : <?php echo $vizualizari; ?></td>
                    <td><div id="rating_php_output">Rating : <?php echo $row['rating'] ?> voturi </div></td>
                    <td><img src="../images/icons/thumb_up.JPG"   style="cursor:pointer" onclick="like('<?php echo $row['product_id'] ?>')" title="Imi place"/></td>
                    <td><img src="../images/icons/wishlist.JPG"  style="cursor:pointer" onclick="addToWishList('<?php echo $row['product_id'] ?>')"title="Adauga la wishlist"/></td>
                    <td><img src="../images/icons/add_to_cart.jpg"   style="cursor:pointer" onclick="AddToCart('<?php echo $row['stoc'] ?>')" title="Pune in cosul de cumparaturi" /></td>
                    <td><img src="../images/icons/checkout.jpg" style="cursor:pointer" title="Comanda acum, fara cont" /></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="3" align="center" nowrap="nowrap" class="arial"><div id="show_details_php_output">&nbsp; </div></td>
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
              <td><form action="show_details.php" method="get" id="bestSeller">
                <input type="hidden" name="product_id" id="product_id"/>
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
