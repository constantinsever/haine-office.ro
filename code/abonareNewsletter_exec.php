<?php

$email = $_GET['email'];

 require_once('connect.php');
  $con = connect_to_db();

  $query = "select * from newsletter where email='". $email. "';";
  $result= mysql_query($query);
    $num = mysql_num_rows($result);
   if ($num != 0)
    die("Deja inregistrat");

  $res = mysql_query("select * from ho_users where email='". $email. "' limit 1;");
    $num = mysql_num_rows($res);
   if ($num != 0)
    {
	 $r = mysql_fetch_array($res);
	 $username = $r['username']; 
	 }
	 
	 else
	  $username = "Unregistered user";
	
  $res = mysql_query("INSERT INTO newsletter (username, email) VALUES ('".$username."','".$email."');");
   echo "Abonare OK";

 mysql_close($con);

?> 
