<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
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
          <td align="left" valign="top" >
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><a href="index.php"><img src="../images/icons/tie.jpg" width="140" height="130" border="0" /></a></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            
            <tr>
              <td align="left" valign="top">
			  <form name="select_category" action="browse_products.php" method="GET">
	   
	   
	   <?php

				  require_once('connect.php');
				  $con = connect_to_db();
				  $query = "select * from categories where childOf='root';"; // extrag parintii
					 
				  $result= mysql_query($query);
				  $num_records = mysql_num_rows($result);
				 
			
				  echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"5\" class=\"rounded_corner\">";
				  echo "<tr><td>";
			      
  			      if ($num_records != 0)
				  {
				   echo "<a href=\"javascript: void(0)\" onclick=\"showProducts('root',1)\">Toate produsele</a><br>";
				   while($parinti = mysql_fetch_array($result))
				   {
					echo "<a  href=\"javascript: void(0)\" onclick=\"showProducts(".$parinti['category_id'].",1)\">&nbsp;&nbsp;".$parinti['category_name']."</a><br>";
				
					 $query1 = "select * from categories where childOf = '".$parinti['category_id']."';"; // extrag fii pentru fiecate parinte
					 $result1= mysql_query($query1);
					 $num_records1 = mysql_num_rows($result1);
					 if ($num_records1 != 0)
						 while($fii = mysql_fetch_array($result1))
						 {
						  echo "<a href=\"javascript: void(0)\" onclick=\"showProducts(".$fii['category_id'].",1)\">&nbsp;&nbsp;&nbsp;&nbsp;".$fii['category_name']."</a><br>";
						   $query2 = "select * from categories where childOf = '".$fii['category_id']."';"; // extrag nepotii pentru fiecate parinte
						   $result2= mysql_query($query2);
						   $num_records2 = mysql_num_rows($result2);
						   if ($num_records2 != 0)
 						   while($nepoti = mysql_fetch_array($result2))
							{
							 echo "<a href=\"javascript: void(0)\" onclick=\"showProducts(".$nepoti['category_id'].",1)\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nepoti['category_name']."</a><br>";
							 };
						   
						  };
					  }; //while
					 }; //if
					 echo "</td></tr></table>";
			
				  ?>  
			
	   
	   
			  
			  <input name="hiddenCategory" type="hidden" value="" />
			  <input name="hiddenIndex" type="hidden" value="" />
			  </form>			  </td>
            </tr>
			
			<tr>
			  <td>&nbsp;</td>
			  </tr>
			
			
			<tr>
			  <td>
			  <form name="search_form" action="search.php" method="GET">
			    <table width="100%" height="0" border="0" cellpadding="3" cellspacing="0" bordercolor="#E9E9E9" class="rounded_corner">
                  <tr>
                    <td colspan="2" align="center"><span class="bold">Cautare produse </span></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="searchCriteria" type="text" class="box_120" id="searchCriteria" /></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><input name="Button" type="button" class="box_100" onclick="searchProducts(this.form.searchCriteria.value,1)" value="Cautare"/></td>
                  </tr>
                  <input type="hidden" name="searchIndex" id="searchIndex" value="1"/>
                </table>
			  </form>			  </td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td><table width="100%" height="0" border="0" cellpadding="3" cellspacing="0" bordercolor="#E9E9E9" class="rounded_corner">
                <tr>
                  <td colspan="2" align="center"><span class="bold">Ofertele zilei pe mail </span></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input name="emailNewsletter" type="text" class="box_120" id="emailNewsletter" value="adresa email ..." onclick="this.value=''"/></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input name="Button2" type="button" class="box_100" onclick="abonareNewsletter()" value="Abonare"/></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" class="arial"><div id="aaa"></div></td>
                </tr>
              </table></td>
			  </tr>
			<tr>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          <td align="center" valign="top">
		  
		  
		  <?php

			$username = $_POST['create_username'];
			$password= $_POST['password1'];
			$fullname = $_POST['fullname'];
			$address= $_POST['address'];
			$email = $_POST['email'];
			$phone= $_POST['phone'];
			
			$error = "";
			 require_once('connect.php');
			  $con = connect_to_db();
			
			  $query = "select * from ho_users where username='". $username. "';";
			  $result= mysql_query($query);
				$num = mysql_num_rows($result);
			   if ($num != 0)
				 $error = "<span class=\"bold\">Exista deja un cont numele '<i>".$username."</i>' . Contul nu a fost creat.</span>";
				
			 
			  $query = "select * from ho_users where phone='". $phone. "';";
			  $result= mysql_query($query);
				$num = mysql_num_rows($result);
			   if ($num != 0)
				$error = "<span class=\"bold\">Exista deja un cont cu numarul de telefon '<i>".$phone."</i>' . Contul nu a fost creat.</span>";
			 
			   
			  $query = "select * from ho_users where email='". $email. "';";
			  $result= mysql_query($query);
				$num = mysql_num_rows($result);
			   if ($num != 0)
				$error = "<span class=\"bold\">Exista deja un cont cu adresa de mail '<i>".$email."</i>' . Contul nu a fost creat.</span>";
			
			
			 if ($error == "")
			  {
			   mysql_query("INSERT INTO ho_users (username,user_group,password,fullname,address,phone,email,rating, active) VALUES ('".$username."','users','".$password."', '".$fullname."', '".$address."', '".$phone."', '".$email."','0','1');");
			 
			   if ( (isset($_GET['newsletter'])) && ($_GET['newsletter'] == 'true'))
			    mysql_query("INSERT INTO newsletter (username, email) VALUES ('".$username."','".$email."');");
			
			    echo " <div style=\"bold\">Bun venit, <b>".$fullname."</b> ! Contul tau a fost creat cu succes !</div>";
                }
				
				else
				 {
				  echo $error;	
				   echo"<br><span class=\"bold\">Corectati problemele aparute si incercati din nou.</span>";			
				  };
			
			 mysql_close($con);
			
			?>
					  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  </td>
          <td align="left" valign="top">
		    <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>			  </td>
            </tr>
            
            <tr>
              <td>
			    <div id="login_php_output" class="rounded_corner">
			      <?php
			   if ( (!isset($_SESSION['registered'])) || ((time() - $_SESSION['registered']) > 120 ))
				{ ?>
			      <form name="login_form">
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
				   { ?>

			      <table width="100%" border="0" cellpadding="3" cellspacing="0">
			          <tr><td class="bold">Salut, <?php echo $_SESSION['username'] ?> !</td></tr>
			          <tr><td nowrap="nowrap"><a href="javascript: void(0)"  onclick="document.location='shoppingCart.php'" >Cosul de cumparaturi</a><br />
                          <a href="javascript: void(0)" onclick="document.location='wishlist.php'"> Wishlist</a><br />
                          <a href="javascript: void(0)" onclick="showProducts(101,1)">Istoric comenzi</a><br />	
			            <a href="javascript: void(0)" onclick="showProducts(101,1)">Gestiune cont</a><br />	
			            
			            <?php
				 echo "<hr>";
				 echo "<a href=\"javascript: void(0)\" onclick=\"document.location='manageCategories.php'\" >Gestiune produse</a><br>"; 
				 echo "<a href=\"javascript: void(0)\" onclick=\"document.location='userManagement.php'\" >Gestionare utilizatori</a><br>"; 
				 echo "<hr>";
				
		 
				 ?>
			            <a href="javascript: void(0)" onclick="document.location='logout.php'">Iesire din cont</a><br />		   
			            </td></tr>
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
              <td>			  </td>
            </tr>
            <tr>
              <td>
			  <div id="show_me_present+php+output">
			    <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#E9E9E9" class="rounded_corner">
                  <tr>
                    <td nowrap="nowrap" align="left"><a href="javascript: void(0)"  onclick="document.location=''" >Cum cumpar ? </a><br />
                        <a href="javascript: void(0)"  onclick="document.location=''" >Cupoane-cadou </a><br />
                        <a href="javascript: void(0)"  onclick="document.location=''" >Buy-back </a><br />
                      <a href="javascript: void(0)"  onclick="document.location=''" >Ce spun cumparatorii </a></td>
                  </tr>
                </table>
			  </div></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>
			  
				 <?php
				$con1 = connect_to_db();
				
				$query = "select * from produse where cadou='DA';";
				
				$result= mysql_query($query);
				$num_records = mysql_num_rows($result);
				
				if ($num_records != 0 ) 

				{
					$index = rand(0,$num_records-1);
					$i = -1;
					while ($row = mysql_fetch_array($result))
					 {
					 $i++;


					  if ($index == $i)
					   {
							$imageList = $row['imagelist'];
							$imageArray = explode(";",$imageList);
							$image = "../image_uploads/small/".$imageArray[0];
							echo "<form name=\"showPresent\" action=\"show_details.php\" method=\"GET\">";
				            echo "<input type=\"hidden\" name=\"product_id\">";
							echo " <table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" class=\"rounded_corner\">
										<tr>
										  <td colspan=\"2\" align=\"center\" nowrap=\"nowrap\"><span class=\"bold\">Un cadou inspirat </span></td>
										</tr>
										<tr>
										  <td colspan=\"2\" align=\"center\" ><img src=\"".$image."\" onClick=\"document.forms['showPresent'].product_id.value='".$row['product_id']."'; document.forms['showPresent'].submit()\" style=\"cursor:pointer\"/></td>
										</tr>
									  </table>
 							   </form>";
									  
						}
						
					  
					 };
				 
				 };
				  
			 mysql_close($con1);
			
			?>

			  
			  
			  
			  </td>
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
