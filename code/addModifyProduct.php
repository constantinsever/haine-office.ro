<?php
session_start();
require_once('connect.php');
$con = connect_to_db();
				  
$modify = 0;
$action = $_GET['action'];
$product_id = $_GET['id_produs'];
$category_id = $_GET['id_categorie'];


if ($action == 'addProduct')
  $product_id = date("dmyHis", time());
 
if ($action == 'modify')
 {
   $modify = 1;
   $q = "select * from produse where product_id='".$product_id."' limit 1;"; // extrag datele din produsul de editat;
   $res= mysql_query($q);
   $r = mysql_fetch_array($res);
   $category_id = $r['category'];
	 
  };
  
 
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



<SCRIPT language="JavaScript" SRC="addModifyProduct.js"></SCRIPT> 
<SCRIPT language="JavaScript" SRC="accountScripts.js"></SCRIPT> 




<script src="nicEdit.js" type="text/javascript"></script>

<script type="text/javascript" > 
	bkLib.onDomLoaded(function() {
	new nicEditor({buttonList : ['fontSize','bold','italic','underline','strikeThrough','subscript','superscript','ol', 'ul',
								 'left','center','right','justify','forecolor','fontFamily','fontSize'],  maxHeight : 185}).panelInstance('descriere');
								 
   });   
	

</script>



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
		  

		    <table border="1" cellpadding="10" cellspacing="0" bordercolor="#CCCCCC">
                <tr>
                  <td align="left" class="bold">
				   <?php  if ($modify) echo "Modificare produs cod - "; else echo "Adaugare produs nou cod - ";  echo $product_id; ?>			      </td>
                </tr>
				 
                <tr>
                  <td><form action="addModifyProduct_exec.php" name="addModifyProduct_form" id="addModifyProduct_form">
                    <table width="100%" border="0" cellpadding="3" cellspacing="3">
                      <tr>
                        <td colspan="6" align="left" nowrap="nowrap">
						<select name="category_list" id="category_list" size="1" class="box_250" onchange="changeCategory()" >
						<?php
						 $query = "select * from categories where childOf='root';"; // extrag parintii
								 
							$result= mysql_query($query);
							$num_records = mysql_num_rows($result);		  
							while($parinti = mysql_fetch_array($result))
							 { 
								$value = $parinti['category_name'].':'.$parinti['category_id'].":".$parinti['childOf'];
								echo "<option value=\"".$value."\" ";
								if ($parinti['category_id'] == $category_id) // selecteaza categoria selectata in dialogul precedent
								 echo "selected";
								echo ">&nbsp;&nbsp;&nbsp;".$parinti['category_name']."</option>";
								 $query1 = "select * from categories where childOf='".$parinti['category_id']."';"; // extrag fii pentru fiecate parinte
								 $result1= mysql_query($query1);
								 while($fii = mysql_fetch_array($result1))
								 {
								   $value1 = $fii['category_name'].':'.$fii['category_id'].":".$fii['childOf'];
								   echo "<option value=\"".$value1."\"";
								   if ($fii['category_id'] == $category_id) // selecteaza categoria selectata in dialogul precedent
								    echo "selected";
								   echo " >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$fii['category_name']." </option>";
								   $query2 = "select * from categories where childOf='".$fii['category_id']."';"; // extrag nepotii pentru fiecate parinte
								   $result2= mysql_query($query2);
								   while($nepoti = mysql_fetch_array($result2))
									{
									 $value2 = $nepoti['category_name'].':'.$nepoti['category_id'].":".$nepoti['childOf'];
									 echo "<option value=\"".$value2."\"";
									 if ($nepoti['category_id'] == $category_id) // selecteaza categoria selectata in dialogul precedent
								      echo "selected";
									 echo ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nepoti['category_name']."</option>";
									 };
								   
								  };
								  
							 };
							 
							
							 
							 ?>
		                    </select>
                          
                          <input name="titlu" type="text" id="titlu" value="<?php if ($modify) echo $r['titlu']; else echo"...titlul anuntului"; ?>"  style="width:400px;"/></td>
                        </tr>
                      <tr>
                        <td colspan="6" align="left" valign="top" class="arial"><textarea name="descriere" id="descriere" rows="9" class="box_650" ><?php if ($modify) echo $r['descriere'];?>
                        </textarea></td>
                        </tr>
                      <tr>
                        <td nowrap="NOWRAP" class="arial">&nbsp;</td>
                        <td nowrap="NOWRAP" class="arial">&nbsp;</td>
                        <td nowrap="NOWRAP" class="arial">&nbsp;</td>
                        <td nowrap="NOWRAP" class="arial">&nbsp;</td>
                        <td align="center" nowrap="NOWRAP" class="arial">&nbsp;</td>
                        <td align="left" valign="top" nowrap="nowrap" class="arial">&nbsp;</td>
                      </tr>
                      <tr>
                        <td nowrap="NOWRAP" class="arial">Rating &nbsp;</td>
                        <td nowrap="NOWRAP" class="arial"><input name="rating" id="rating" type="text" value="<?php if ($modify) echo $r['rating'];?>"  class="box_50"/></td>
                        <td nowrap="NOWRAP" class="arial"> Pret </td>
                        <td nowrap="NOWRAP" class="arial"><input name="pret" type="text" class="box_50" id="pret" value="<?php if ($modify) echo $r['pret']; else echo"0";?>" onclick="this.value=''" />
RON </td>
                        <td align="center" nowrap="NOWRAP" class="arial">Stoc : 
                          <input name="stoc" type="text" class="box_50" id="stoc" value="<?php if ($modify) echo $r['stoc']; else echo"5";?>" /></td>
                        <td align="left" valign="top" nowrap="nowrap" class="arial">Detalii furnizor :&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="2" nowrap="NOWRAP" class="arial">Promotie
                          <input name="cb_promotie" type="checkbox" id="cb_promotie" value="promotie" <?php if ($modify) if ($r['promotie'] == "DA") echo "checked"; ?>/></td>
                        <td nowrap="NOWRAP" class="arial">Pret promotie &nbsp;</td>
                        <td nowrap="NOWRAP" class="arial"><input name="pret_promotie" type="text" class="box_50" id="pret_promotie" value=" <?php if ($modify) if ($r['promotie'] == "DA") echo $r['pret_promotie']; else echo "0"; ?>"/>
RON</td>
                        <td align="center" nowrap="NOWRAP" class="arial">Cadou
                          <input name="cb_cadou" type="checkbox" id="cb_cadou" value="cadou" checked="checked" <?php if ($modify) if ($r['cadou'] == "DA") echo "checked"; ?>/></td>
                        <td rowspan="3" align="left" valign="top" nowrap="nowrap" class="arial"><textarea name="detalii_furnizor" rows="4"  id="detalii_furnizor" style="width:280px; height:80px; max-height:80px; min-height:80px; max-width:280px; min-width:280px; "><?php if ($modify) echo $r['detalii_furnizor']; else echo""; ?></textarea></td>
                      </tr>
                      <tr>
                        <td colspan="2" nowrap="NOWRAP" class="arial">Marimi disponibile </td>
                        <td colspan="3" nowrap="NOWRAP" class="arial"><input name="size_list" type="text" class="box_200" id="size_list" value="<?php if ($modify) echo $r['size_list']; else echo"38,40,42,44,46"; ?> "/></td>
                        </tr>
                      <tr>
                        <td colspan="2" nowrap="NOWRAP" class="arial">Colori disponibile</td>
                        <td colspan="3" nowrap="NOWRAP" class="arial"><input name="color_list" type="text" class="box_200" id="color_list" value="<?php if ($modify) echo $r['color_list']; else echo"ca in poza"; ?>" /></td>
                        </tr>
                    </table>
					
                  </form></td>
                </tr>
                
                <tr>
                  <td>
				 
				  <form action="uploadImage.php" method="post" enctype="multipart/form-data" target="targetIframe" name="uploadImage_form" >
				  
				  <table width="100%" border="0" cellpadding="5">
                    
                    <tr>
                      <td align="left" valign="top" nowrap="NOWRAP" >
					   <input name="imageFile" type="file" size="50" />
					   <span class="arial">
					   <input name="imageList" type="hidden" id="imageList" />
					   </span></td>
                      <td align="center" valign="middle" nowrap="NOWRAP" ><input name="button" type="button" class="box_200" onclick="addImage()" value="Adauga imagine"/></td>
                      </tr>
                    
                    <tr>
                      <td rowspan="2" align="left" valign="top" nowrap="nowrap" ><select name="filenames" size="10" class="box_400" id="filenames" onchange="changeImage()" >
                        <?php
						  if ($modify)
						   {
						    $imageArray = explode(";",$r['imagelist']);
						    for ($i=0; $i < count($imageArray); $i++)
						    echo "<option value=\"".$imageArray[$i]."\">".$imageArray[$i]."</option>";
							};

						  ?>
                      </select></td>
                      <td align="center" valign="middle" nowrap="NOWRAP" ><input name="button3" type="button" class="box_200" onclick="deleteFile()" value="Sterge imaginea selectata"/></td>
                    </tr>
                    <tr>
                      <td rowspan="2" align="center" valign="middle" nowrap="NOWRAP" ><img src="../images/icons/no_image.jpg"  name="preview_image"  id="preview_image" /></td>
                    </tr>
                    
                    
                      <tr>
                        <td align="center"  valign="top" nowrap="nowrap" class="arial" ><input name="button2" type="button" class="box_150"
					            onclick="applyChanges(<?php if ($modify) echo "'modify'" ; else echo "'addProduct'" ?>)" value="<?php if ($modify) echo "Aplica modificarile" ; else echo "Adauga produsul" ?> " />
                          <input name="filename" type="hidden" id="filename" />                          <input name="uploadAction" type="hidden" id="uploadAction" /></td>
                        </tr>
                      <tr>
                      <td colspan="2" align="center"  valign="top" nowrap="nowrap" class="arial" >
					  <div id="addProduct_php_output"></div>					  </td>
                      </tr>
                  </table>			      
				  </form>				  </td>
                </tr>
              </table>	        </td>
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
          <td align="center">
		  <form name="manageAction" action="addModifyProduct.php" method="GET">
		    <input name="id_categorie" type="hidden" id="id_categorie" value="<?php echo $category_id;?>" />
		    <input name="id_produs" type="hidden" id="id_produs" value="<?php echo $product_id; ?>" />
		    <input name="action" type="hidden" id="action" />
          </form>          
		 </td>
          <td align="center">&nbsp;</td>
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
  <iframe id="targetIframe" name="targetIframe"  style="width:10px;height:10px;border:1px solid #fff; visibility:hidden"></iframe>
</div>


</body>
</html>
