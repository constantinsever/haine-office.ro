<?php
session_start();
require_once('connect.php');
$con = connect_to_db();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="haine, office, palton paltoane, sacou, sacouri, costum, costume, accesorii, office, tinuta, profesionala, tinuta profesionala, costum elegant, costum birou, costum secretara, secretariat">
<meta name="description" content="Haine-Office.ro - eleganta la un click distanta. Primul magazin online din Romania dedicat exclusiv aspectului tau profesional la birou.">
<title>Haine Office - Eleganta la un click distanta. Primul magazin online dedicat exclusiv aspectului tau profesional la birou.</title>
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
-->
</style>


<script src="jquery-1.7.1.min.js"></script>

<link rel="stylesheet" href="anythingSlider/css/anythingslider.css">
<script src="anythingSlider/js/jquery.anythingslider.js"></script>
<script type="text/javascript">
// DOM Ready
$(function(){
	$('#slider').anythingSlider({
			buildArrows  : false,
            autoPlay            : true     // This turns off the entire slideshow FUNCTIONALY, not just if it starts running or not
        });
});
</script>



<SCRIPT language="JavaScript" SRC="product_functions.js"></SCRIPT> 
<SCRIPT language="JavaScript" SRC="accountScripts.js"></SCRIPT> 


<style type="text/css">
<!--
.style2 {color: #FFFFFF}
-->
</style>
</head>

<body  >
<div id="Layer1" >
  <table  border="0" cellpadding="0" cellspacing="0" class="rounded_corner">
    <tr>
      <td>
	  <table  border="0" cellpadding="1" cellspacing="5">
      
        <tr>
          <td rowspan="2" align="left" valign="top" ><table border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td colspan="3" align="center"><a href="index.php"><img src="../images/icons/ho.jpg"  border="0" /></a></td>
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
              <td colspan="3" align="center" bgcolor="#003366" class="bold style2">Alte produse de vizitat acum </td>
            </tr>
            <tr>
              <td colspan="3" align="center"><form action="show_details.php" method="get" name="showPresent" id="showPresent">
			  <input type="hidden" id="product_id" name="product_id" />
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
							echo " <img src=\"".$image."\" title=\"".$row1['titlu']."\"onClick=\"document.forms['showPresent'].product_id.value='".$row1['product_id']."'; document.forms['showPresent'].submit()\" style=\"cursor:pointer\"/>&nbsp;";
									  
						}
					 };
				 };
				  			
			?>
              </form></td>
            </tr>
			 <tr>
              <td colspan="3" background="../images/icons/dotted.jpg" style="background-repeat:repeat-x">&nbsp;</td>
            </tr>
			 <tr>
              <td colspan="3">&nbsp;</td>
            </tr>
          </table></td>
          <td colspan="5" rowspan="3" align="center" valign="top"><?php 

				 
    			$result= mysql_query("select * from produse where promotie='DA' ;");

  
			    $num_records = mysql_num_rows($result);

				
				if ($num_records == 0)
				 {
				 
				  
  				   echo "<span class=\"bold\">Nu s-au gasit produse cu criteriul specificat.</span>";
		    	  } 
				
                 else				
				 {

		   	       echo "<form name=\"show_details\" action=\"show_details.php\" method=\"GET\">";
				   echo "<input type=\"hidden\" name=\"product_id\">";
	
				   $k = 0;
				   echo "<ul id=\"slider\">";
				   while($row = mysql_fetch_array($result))
				    {
					
					  $imageList = $row['imagelist'];
				      $imageArray = explode(";",$imageList);

						  echo "
						  <li>
						   <div onClick=\"document.forms['show_details'].product_id.value='".$row['product_id']."'; document.forms['show_details'].submit()\" style=\"cursor:pointer\" >
					       <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
						    <tr><td  align=\"center\" rowspan=\"4\"><img src=\"../image_uploads/".$imageArray[0]."\" width=\"210\" height=\"250\" ></td></tr>
							<tr><td  height=\"25\" align=\"left\" class=\"bold\" colspan=\"2\">".$row['titlu']."</td></tr>
							<tr><td  height=\"25\"  align=\"left\" class=\"arial\" colspan=\"2\">".$row['descriere']."</td></tr>
					        <tr>
							 <td  height=\"25\" align=\"center\"  class=\"bold\" >";
							   if  ($row['stoc'] > 0 ) echo "<span style=\"color:#006633; \">Livrare directa din stoc<span> ";
					            else
					           echo "<span style=\"color:#FF0000;\">Livrare la comanda<span> ";
						 
						     echo "</td>
							 <td  height=\"25\" align=\"center\"  class=\"bold\" ><span style=\"color:#FF0000;\">Pret special : ".$row['pret_promotie']." &nbsp;RON<span></td>
							</tr>
        			       </table>
						   </div>
						   </li>
						    ";

						
				     };
					
                   echo "</ul></form>"; 

				  };
				  
				 ?></td>
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
                          <a href="javascript: void(0)" onclick="document.location='logout.php'">Iesire din cont</a><br />                      </td>
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
              <td align="center" class="bold">
			  <form action="show_details.php" method="get" name="bestSeller" id="bestSeller">
                  <input type="hidden" name="product_id" id="product_id"/>
			      <table border="0" cellspacing="0" width="100%" bordercolor="#E9E9E9" class="rounded_corner">
				   <tr><td class="bold" align="center" > Bestsellers</td></tr>
				   <tr><td align="center">
                  <?php
			
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
              
			  </td></tr></table>
			  </form>			  </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        
        
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        
        <tr>
          <td align="center" valign="middle" class="arial">&nbsp;</td>
          <td align="center"><a href="javascript: void(0)" onclick="document.location='logout.php'">Intrebari frecvente</a></td>
          <td align="center"><a href="javascript: void(0)" onclick="document.location='logout.php'">Reguli de functionare</a></td>
          <td align="center"><a href="javascript: void(0)" onclick="document.location='logout.php'">Distributie</a></td>
          <td align="center"><a href="javascript: void(0)" onclick="document.location='logout.php'">Campanii umanitare</a></td>
          <td align="center"><a href="javascript: void(0)" onclick="document.location='logout.php'">Contact</a></td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" >		  </td>
          <td colspan="5" align="center"><img src="../images/spacers/spacer_1.jpg " width="800" height="1" /></td>
          <td align="center"><img src="../images/spacers/spacer_1.jpg " width="150" height="1" /></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>



</body>
</html>
