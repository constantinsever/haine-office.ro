<?php

function connect_to_db(){
 $con = 0;

//$con = mysql_connect('localhost', 'haineoff', 'Cou8cn209M');
$con = mysql_connect('localhost', 'root', 'root');
if (!$con)
  die('Could not connect: ' . mysql_error());
 
mysql_select_db("haineoff_central", $con);
//mysql_select_db("haineoff_central", $con);
 

 return $con;

};

?> 


