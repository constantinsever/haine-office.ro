<?php
session_start();
    
	

	require_once('connect.php');
	$con = connect_to_db();
	 
	$action = $_GET['action']; 


   switch ($action)
    {
	 case "show_categories" :
 	       showCategories(); 
		   break;
	 
     case "deleteCategory" :
	       deleteCategory();
		   break;
	 
	 case "showCategoryProducts":
	       showCategoryProducts();
		   break;

 	 case "addCategory":
	       addCategory();
		   break;
 	 case "renameCategory":
	       renameCategory();
		   break;
	 case "deleteProduct":
	       deleteProduct();
		   break;
	
		   
	 default : break;
	 };	   
	  
	  
	  
	 
	function showCategories()
	{ 
	
	echo "<table width=\"95%\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\" bordercolor=\"#CCCCCC\"  >
					<tr>
					  <td align=\"left\" nowrap=\"nowrap\" class=\"bold\">Gestiune categorii Haine-Office </td>
					</tr>
					<tr>
					  <td align=\"left\" nowrap=\"nowrap\" class=\"bold\">";
	
	
	 if ( (isset($_SESSION['group'])) && ($_SESSION['group'] == "administrators") && ((time() - $_SESSION['registered']) < 300 ))
	  {	
		  
		  
		echo " 
					  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" >
						  <tr>
							<td width=\"47%\" rowspan=\"5\" valign=\"top\">
							  <select name=\"category_list\" size=\"12\" id=\"category_list\" class=\"box_300\" onClick=\"showCategoryProducts()\">
							  <option value=\"root:root:0\">home</option>";
						
							  
		 
					$query = "select * from categories where childOf='root';"; // extrag parintii
						 
					$result= mysql_query($query);
					$num_records = mysql_num_rows($result);		  
					while($parinti = mysql_fetch_array($result))
					 { 
						$value = $parinti['category_name'].':'.$parinti['category_id'].":".$parinti['childOf'];
						echo "<option value=\"".$value."\">&nbsp;&nbsp;&nbsp;".$parinti['category_name']."</option>";
						 $query1 = "select * from categories where childOf='".$parinti['category_id']."';"; // extrag fii pentru fiecate parinte
						 $result1= mysql_query($query1);
						 while($fii = mysql_fetch_array($result1))
						 {
						   $value1 = $fii['category_name'].':'.$fii['category_id'].":".$fii['childOf'];
						   echo "<option value=\"".$value1."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$fii['category_name']." </option>";
						   $query2 = "select * from categories where childOf='".$fii['category_id']."';"; // extrag nepotii pentru fiecate parinte
						   $result2= mysql_query($query2);
						   while($nepoti = mysql_fetch_array($result2))
							{
							 $value2 = $nepoti['category_name'].':'.$nepoti['category_id'].":".$nepoti['childOf'];
							 echo "<option value=\"".$value2."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nepoti['category_name']."</option>";
							 };
						   
						  };
						  
					 };
	
						  echo "    </select>
							 </td>
							 <td colspan=\"2\"  align=\"center\" nowrap=\"nowrap\"><div id=\"category_name\" style=\"color:#FF0000\">Selectati o categorie de produse...</div></td>
						   </tr>
						   <tr>
							<td width=\"30%\"  align=\"left\" nowrap=\"nowrap\"><a href=\"javascript: void(0)\" onclick=\"showForm('add')\">Adaugare sub-categorie</a> </td>
							<td  align=\"left\"  nowrap=\"nowrap\"><a href=\"javascript: void(0)\" onclick=\"addModifyProduct('addProduct','0')\">Adaugare produs nou</a></td>
						  </tr>
						  <tr>
							<td align=\"left\"  nowrap=\"nowrap\"><a href=\"javascript: void(0)\" onclick=\"showForm('rename')\">Redenumire categorie</a></td>
							<td  align=\"left\"  nowrap=\"nowrap\"><a href=\"javascript: void(0)\" >&nbsp;</a></td>
						  </tr>
						   <tr>
							<td  align=\"left\"  nowrap=\"nowrap\"><a href=\"javascript: void(0)\" onclick=\"showForm('delete')\">Stergere categorie</a></td>
							<td  align=\"left\"  nowrap=\"nowrap\">
							  <input name=\"id_produs\" type=\"hidden\" id=\"id_produs\" value=\"0\" />
							  <input name=\"id_categorie\" type=\"hidden\" id=\"id_categorie\" value=\"0\" />
							  <input name=\"action\" type=\"hidden\" id=\"action\" value=\"0\" />
							</td>
						  </tr>
						  <tr>
							<td colspan=\"3\">Produse in categoria selectata : </td>
						  </tr>
						  <tr>
							<td colspan=\"3\">
							<div id=\"show_category_products\" style=\"border-style:solid; border-width:thin; width:100%; height:280px; overflow:scroll\">
							</div>
							</td>
						  </tr>
						  
					  </table>";
		
		
		}
		
		 else echo "Nu aveti drepturi de administrare produse in acest moment !";
          
		 echo "</td></tr></table> ";           
                  
	  };			  
	
	
	function showCategoryProducts()
	{ 
	 $cat_fii = array();
	 $cat_nepoti = array();
	 $produse_parinte = array();
	 $produse_fii = array();
	 $produse_nepoti = array();
	 $produse_root = array();
	 
	 $num_records = 0;
	 
	echo "<table border=\"0\" cellpadding=\"5\" width=\"100%\">";
	 $category = $_GET['category'];
	 if ($category == "root")
	   {
	    $produse_root =  mysql_query("select * from produse;");
		$num_records = addInTable($produse_root);
		}
     else
	  {
	  
	   $produse_parinte = mysql_query("select * from produse where category='".$category."';");
		$num_records = $num_records + addInTable($produse_parinte);
	   $cat_fii= mysql_query("select * from categories where childOf='".$category."';");
       if (mysql_num_rows($cat_fii) != 0)
	    while ($fii = mysql_fetch_array($cat_fii))
		  {
		   $produse_fii = mysql_query("select * from produse where category='".$fii['category_id']."';");
		   $num_records = $num_records + addInTable($produse_fii);
		    $cat_nepoti= mysql_query("select * from categories where childOf='".$fii['category_id']."';"); 
 	        if (mysql_num_rows($cat_nepoti) != 0)
			  while ($nepoti = mysql_fetch_array($cat_nepoti))
			   $produse_nepoti = mysql_query("select * from produse where category='".$nepoti['category_id']."';");
			   if (mysql_num_rows($cat_nepoti) != 0)
 			    $num_records = $num_records + addInTable($produse_nepoti);
		   };

		};
	 
	 echo "<tr><td colspan=\"4\" align=\"center\">";
	
	   if ($num_records == 0)
	   	echo "In aceasta categorie nu sunt produse."; 
		else
	  	echo "S-au gasit ".$num_records." produse in categorie."; 
	  echo "</td></tr>"; 
	 echo "</table>";
	   
     
	              
	  };			  
	
  function addInTable($result)
   {
    if (count($result) == 0)
	 return 0;
	
    $count = 0;
	while($row = mysql_fetch_array($result))
	 {
	  $imageList = $row['imagelist'];
	  $imageArray = explode(";",$imageList);
		 echo "<tr>
				 <td align=\"center\"  style=\"cursor:pointer\" onclick=\"showDetails('".$row['product_id']."')\"><img src=\"/image_uploads/small/".$imageArray[0]."\" ></td>
				 <td class=\"arial\" valign = \"top\" align=\"left\">".$row['titlu']."
				  <br> ID Produs : ".$row['product_id'].", stoc: ".$row['stoc']."
  				  <br><textarea rows=\"4\" cols=\"40\" readonly>".$row['detalii_furnizor']."</textarea>
				 </td>
				 <td class=\"arial\" align=\"left\">".$row['pret']." RON</td>
				 <td>
				  <a href=\"javascript: void(0)\" onClick=\"addModifyProduct('modify','".$row['product_id']."')\" >Modifica</a><br><br>
				  <a href=\"javascript: void(0)\" onClick=\"deleteProduct('".$row['product_id']."','".$row['titlu']."')\" >Sterge</a>
				 </td>
			  </tr>
			  <tr><td colspan=\"4\"><hr></td>
			  </tr> ";	
	     $count  ++ ;		  
	
		};
  return $count;
};




	function deleteCategory()
	{ 
	 $category_id = $_GET['category_id'];

     
    mysql_query("delete from produse where category='".$category_id."';"); // stergere produse din categoria selectata;
	 
	 $result1 = mysql_query("select * from categories where childOf='".$category_id."';"); 
     while($fii = mysql_fetch_array($result1))
	  {
	   mysql_query("delete from produse where category='".$fii['category_id'] ."';");   // stergere produse din toti fiii
       
	   $result2 = mysql_query("select * from categories where childOf='".$fii['category_id']."';"); // cautare nepoti
	    while($nepoti = mysql_fetch_array($result2))
		 {
		   mysql_query("delete from produse where category='".$nepoti['category_id']."';");   // stergere produse din nepoti
		   mysql_query("delete from categories where category_id='".$nepoti['category_id']."';");   // stergere categoria-nepoti
		  };
	    mysql_query("delete from categories where category_id='".$fii['category_id']."';");   // stergere categorie-fiu
	   
	   };
	  mysql_query("delete from categories where category_id='".$category_id."';");   // stergere categorie selectata

     showCategories();
	              
	  };			  
	
	
	function addCategory()
	{ 
     $commandString = $_GET['commandString'];

	 $params = explode(':',$commandString);
	 $category_name = $params[0];
	 $category_id = $params[1];
	 $childOf = $params[2];

	  mysql_query("insert into categories(category_name, category_id, childOf) values ('". $category_name."','".$category_id."','".$childOf."');"); 

	  showCategories();
	              
  };			  
	
	function renameCategory()
	{ 
	  $new_name = $_GET['new_name'];
      $old_name = $_GET['old_name'];
	  $new_name = $_GET['new_name'];
	  
	  $query = "update categories set category_name='".$new_name."' where category_name='".$old_name."';"; 
	  $result= mysql_query($query);
	  
    showCategories();
   };
	  
	 
	function deleteProduct()
	{ 
	  $product_id = $_GET['product_id'];
	  
	  $query = "delete from produse where product_id='".$product_id."';"; 

	  $result= mysql_query($query);
	showCategoryProducts();
	                 
	  };
	  
	  
	  
	
   mysql_close($con);	 

?>
