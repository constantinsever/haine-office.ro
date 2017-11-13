<?php
session_start();
$_SESSION['current_index'] = 0;
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

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--

#main_layer {
	position:absolute;
	left:25px;
	top:26px;
	width:836px;
	height:653px;
	z-index:0;
}
-->
</style>



<SCRIPT language="JavaScript" SRC="manageCategories.js"></SCRIPT>
<SCRIPT language="JavaScript" SRC="accountScripts.js"></SCRIPT> 
<script language="javascript">


function showDetails(product_id){
url = "show_details.php";
 url=url+"?product_id="+product_id;
 document.location = url; 
}


function showProducts(category, index){
 document.select_category.hiddenCategory.value = category;
 document.select_category.hiddenIndex.value = index;
 
 document.select_category.submit();
}


</script>
</head>

<body onload="showCategories()" >
<div id="form_layer" style=" position:absolute; top:170px; left:500px; z-index:1;  border:thin; border-style:solid; background-color:#FFFFFF; visibility:hidden"></div>
<div id="main_layer">
  <table  border="0" cellpadding="0" cellspacing="0" class="rounded_corner">
    <tr>
      <td><table  border="0" cellpadding="1" cellspacing="5" id="main_table">
          <tr>
            <td align="left" valign="top" ><table border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td colspan="3" align="center"><a href="index.php"><img src="../images/icons/ho.jpg" width="200" height="57" border="0" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="3" align="left" valign="top" nowrap="nowrap" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
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
                <td height="12" colspan="3" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
              </tr>
              <tr>
                <form action="search.php" method="get" name="search_form" id="search_form">
                  <td height="22" align="center" class="bold">Cautare</td>
                  <td align="center"><input name="searchCriteria" type="text" class="box_120" id="searchCriteria" /></td>
                  <td align="right" valign="middle"><img src="../images/icons/search.png" onclick="searchProducts(document.search_form.searchCriteria.value,1)" title="Cautare" /></td>
                  <input type="hidden" name="searchIndex" id="searchIndex" value="1"/>
                </form>
              </tr>
              <tr>
                <td height="12" colspan="3" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
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
			<form name="manage_form" action="addModifyProduct.php" method="GET">
				<div id="manage_php_output">
				
				<table width="95%" border="1" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" class="rounded_corner">
					<tr>
					  <td align="left" nowrap="nowrap" class="bold">Gestiune categorii Haine-Office </td>
					</tr>
					<tr>
					  <td align="left" nowrap="nowrap" class="bold">
					  
					  <?php
						if ( (isset($_SESSION['group'])) && ($_SESSION['group'] == "administrators") && ((time() - $_SESSION['registered']) < 300 ))
						 {
						 ?>
					  
					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="5">
						  <tr>
						     <td width="47%" rowspan="5" valign="top">
						     <select name="category_list" size="12" id="category_list" class="box_250" onchange="showCategoryProducts()">
					         </select>                        </td>
						     <td colspan="2"  align="center" nowrap="nowrap"><div id="category_name" style="color:#FF0000">Selectati o categorie de produse...</div></td>
				          </tr>
					      <tr>
							<td width="30%"  align="left" nowrap="nowrap"><a href="javascript: void(0)" onclick="showForm('add')">Adaugare sub-categorie</a> </td>
							<td width="21%"  align="left"  nowrap="nowrap"><a href="javascript: void(0)" onclick="addModifyProduct('modify','0')">Adaugare produs 
							  
							</a></td>
						  </tr>
						  <tr>
							<td align="left"  nowrap="nowrap"><a href="javascript: void(0)" onclick="showForm('rename')">Redenumire categorie</a></td>
							<td  align="left"  nowrap="nowrap"><a href="javascript: void(0)" onclick="showForm('delete')">
							  <input name="action" type="hidden" id="action" value="0" />
							  <input name="id_produs" type="hidden" id="id_produs" value="0" />
							  <input name="id_categorie" type="hidden" id="id_categorie" value="0" />
							</a></td>
						  </tr>
						  
						  <tr>
							<td align="left"  nowrap="nowrap"><a href="javascript: void(0)" onclick="showForm('delete')">Stergere categorie</a></td>
							<td align="left"  nowrap="nowrap">&nbsp;</td>
						  </tr>
						  <tr>
							<td colspan="2" align="left"  nowrap="nowrap"><hr /></td>
						  </tr>
						  <tr>
							<td colspan="3">Produse in categoria selectata : </td>
						  </tr>
						  <tr>
							<td colspan="3">
							<div id="show_category_products" style="border-style:solid; border-width:thin; width:100%; height:280px; overflow:scroll">						</div>						</td>
						  </tr>
					  </table>
					   <?php 
					    }
						else echo "Nu aveti drepturi de administrare produse in acest moment !";
					    ?>
					  
					  </td>
					</tr>
				</table>
				</div>
			</form>
			
			</td>
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
                  <td align="center" nowrap="nowrap"><a href="javascript: void(0)" onclick="document.location='/code/logout.php'">Intrebari frecvente </a></td>
                  <td align="center" nowrap="nowrap"  ><a href="javascript: void(0)" onclick="document.location='/code/logout.php'">Reguli de functionare</a> </td>
                  <td align="center" nowrap="nowrap" ><a href="javascript: void(0)" onclick="document.location='/code/logout.php'">Distributie</a> </td>
                  <td align="center" nowrap="nowrap"  ><a href="javascript: void(0)" onclick="document.location='/code/logout.php'">Campanii umanitare</a> </td>
                  <td align="center" nowrap="nowrap"  ><a href="javascript: void(0)" onclick="document.location='/code/logout.php'">Contact</a></td>
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
