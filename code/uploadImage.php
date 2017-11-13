<?php
  include('SimpleImage.php');
  
  $action = $_POST['uploadAction'];
  if ($action == "uploadImage")
   {
    $destination_path = "../image_uploads/";
    $result = "ERROR";
	$filename =  date("dmyHis", time())."_".basename( $_FILES['imageFile']['name']);
    $target_path = $destination_path .$filename;
  
    if(@move_uploaded_file($_FILES['imageFile']['tmp_name'], $target_path)) 
	 {
	  //sleep(1);
	  $image = new SimpleImage();
	  
	  $image->load("../image_uploads/".$filename);
	  $image->resizeToHeight(100);
	  $image->save("../image_uploads/small/".$filename);

	  
	  echo "OK upload";
	  ?>
 	  <script language="javascript" type="text/javascript">
 	   window.top.window.addFilename('<?php echo $filename ."','".$filename;?>');
       window.top.window.showStatus("complete",1);
	  
	  </script> 
	  <?php
	  }
	 else
      {
	  echo "eroare upload ". $_FILES['imageFile']['error'];
	   ?>
	   <script language="javascript" type="text/javascript">
 	    window.top.window.showStatus("error",1); 
	    </script> 
	
	  <?php
	  };
	   
	   
    };
	  
  if ($action == "deleteFile")
   {
    $filename = $_POST['filename'];
	$name = "../image_uploads/".$filename;
	$name1 = "../image_uploads/small/".$filename;
	
	$error = 0;
	
	
	if ( !file_exists($name) || !file_exists($name1))
	 $error = 1;
	 else
	 {
	  unlink($name);
      unlink($name1);
	  ?>
	  <script language="javascript" type="text/javascript">
 	   window.top.window.deleteFilename();
	  </script> 
	  <?php
	  
	  }
	
	if ($error != 0)
 	 echo "File does not exist"; 
	
	
    };
	  
	  
 ?>
	 
	 
