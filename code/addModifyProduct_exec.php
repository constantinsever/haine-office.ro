<?php
 
  require_once('connect.php');
  $con = connect_to_db();

   $owner = "root";
   $titlu = $_GET['titlu'];
   $descriere =  $_GET['descriere'];
   $pret =  $_GET['pret'];
   
  
   $imageList = $_GET['imageList'];
   
   $cadou = $_GET['cadou'];
   $promotie = $_GET['promotie'];
   $pret_promotie = $_GET['pret_promotie'];
   $rating = $_GET['rating'];
   
   $action = $_GET['action'];
   $product_id=$_GET['id_produs'];
   $category = $_GET['id_categorie'];
   $color_list = $_GET['color_list'];
   $size_list = $_GET['size_list'];
   $detalii_furnizor = $_GET['detalii_furnizor'];
   $stoc = $_GET['stoc'];
   
 
   
 
   if ($action == 'addProduct')
    {
	 $query = "INSERT INTO produse (product_id, titlu, descriere, imagelist, category, pret, rating, promotie, pret_promotie, cadou, color_list, size_list, detalii_furnizor, stoc ) VALUES ('".$product_id."', '".$titlu."', '".$descriere."', '".$imageList."', '".$category."', '".$pret."', '0', '".$promotie."', '".$pret_promotie."', '".$cadou."'  , '".$color_list."' , '".$size_list."' , '".$detalii_furnizor."' ,'".$stoc."');";
	 echo "Produs adaugat cu succes.";
	 }
    else
	 {
	  $query = "UPDATE produse SET  titlu='".$titlu."', descriere='".$descriere."', imagelist='".$imageList."', category='".$category."', pret='".$pret."', rating='".$rating."', promotie='".$promotie."', pret_promotie='".$pret_promotie."', cadou='".$cadou."' , color_list='".$color_list."' , size_list='".$size_list."' , detalii_furnizor='".$detalii_furnizor."' , stoc='".$stoc."' where product_id='".$product_id."';";
	  echo "Produs modificat cu succes.";
	  };
	
   mysql_query($query);
   

   
  
 mysql_close($con);


?> 


