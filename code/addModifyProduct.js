var xmlhttp,command, timer_req, url, parameter, active, refresh_count;

function showProducts(category, index){
 document.select_category.hiddenCategory.value = category;
 document.select_category.hiddenIndex.value = index;
 
 document.select_category.submit();
}


function searchProducts(index){

 document.search_form.searchIndex.value = index;
 document.search_form.submit();
}




 function addFilename(text, value){
 var i;
  i = document.getElementById('filenames').options.length;
  if (i == 10) 
   {
	alert("Se pot adauga maxim 10 imagini.");
	return;
   }
 var opt = document.createElement("OPTION");
  opt.text = text;
  opt.value = value;
  if (navigator.appName == "Microsoft Internet Explorer")
    document.getElementById('filenames').add(opt);
  if (navigator.appName == "Netscape")	
  document.getElementById('filenames').appendChild(opt);
 };
 


function changeCategory()
 {    i = document.getElementById('category_list').selectedIndex;  
	 selectedItem = document.getElementById('category_list').options[i].value;
	 
     data = selectedItem.split(':');
	  document.getElementById('id_categorie').value=data[1]; // categoria parinte pentru noul produs
	 
 };

 
 function applyChanges(action){

 document.getElementById('imageList').value = "";
  for(i=0; i < document.getElementById('filenames').options.length; i++)
    document.getElementById('imageList').value = document.getElementById('imageList').value  + document.getElementById('filenames').options[i].text + ";";

  s = document.getElementById('imageList').value;
   s = s.substring(0, s.length-1);// eliminare ultimul ';'
  document.getElementById('imageList').value = s;

 xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }
  
 nicEditors.findEditor('descriere').saveContent(); 
  
 url = "addModifyProduct_exec.php";
 url=url+"?action="+action;
 url=url+"&titlu="+document.getElementById('titlu').value;
 url=url+"&descriere="+document.getElementById('descriere').value;
 url=url+"&pret="+document.getElementById('pret').value;
 url=url+"&category_list="+document.getElementById('category_list').value;
 url=url+"&id_produs="+document.getElementById('id_produs').value;
 url=url+"&id_categorie="+document.getElementById('id_categorie').value;
 url=url+"&imageList="+document.getElementById('imageList').value;
 url=url+"&color_list="+document.getElementById('color_list').value;
 url=url+"&size_list="+document.getElementById('size_list').value;
 url=url+"&detalii_furnizor="+document.getElementById('detalii_furnizor').value;
 url=url+"&stoc="+document.getElementById('stoc').value;
 
 
 
 
 x = document.getElementById('rating');
 if (x != null)
 url=url+"&rating="+document.getElementById('rating').value;
 else 
  alert("Rating null");

 

 if (document.getElementById('cb_cadou').checked)
  url=url+"&cadou=DA";
 else
  url=url+"&cadou=NU";

 if (document.getElementById('cb_promotie').checked)
  {
	  url=url+"&promotie=DA";
      url=url+"&pret_promotie="+document.getElementById('pret_promotie').value;
  }
  
 else
     {
		 url=url+"&promotie=NU";
   	     url=url+"&pret_promotie=0";
	 };

  
 //url=url+"&sid="+Math.random(); !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

 xmlhttp.onreadystatechange=displayResultAddProduct;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

 
 };
 
 
 function displayResultAddProduct()
{
 if (xmlhttp.readyState==4)
 {
 document.getElementById('addProduct_php_output').innerHTML =xmlhttp.responseText;
 }
}
 
  
 function changeImage(){

    var largeImage;
	
    if (document.getElementById('filenames').options.length == 0)
	 return;
	if (document.images)
	{

  	  i = document.getElementById('filenames').selectedIndex;
	  s = document.getElementById('filenames').options[i].text;
	  
	  largeImage = new Image();
      largeImage.src = "/image_uploads/small/"+s;

		
	document["preview_image"].src = largeImage.src;

	};
 }


function showStatus(status,visible)
 {
	 var s;
	 if (status == "loading")
	   s = "<span class=\"arial\">Va rugam asteptati. </span><img src=\"../images/icons/loading.gif\" />";
	 if (status == "complete")
	   s = "<span class=\"arial\">Imagine adaugata. </span><img src=\"../images/icons/success_icon.png\" />";
	 if (status == "error")
	   s = "<span class=\"arial\">Eroare la adaugare ! </span><img src=\"../images/icons/error_icon.jpg\" />";
	   
	   
  if (visible)
    document.getElementById('addProduct_php_output').innerHTML = s;
  else
    document.getElementById('addProduct_php_output').innerHTML = "";
 };


function addImage()
 {
	 selFile = document.forms['uploadImage_form'].imageFile.value;

	 if (document.forms['uploadImage_form'].filenames.options.length >0)
	  {
		
	    for (i = 0; i <= document.forms['uploadImage_form'].filenames.options.length-1 ; i++)
         {	
		  s = document.forms['uploadImage_form'].filenames.options[i].text; 
		  fname = s.substring(13,s.length);		   

           if (selFile.search(fname) != -1)
	      {
	  	  alert("Imaginea a fost incarcata deja. Alegeti alta imagine.");
		  return;
	    };
	  }; 
	  };
	 

	 
						 
    document.forms['uploadImage_form'].uploadAction.value = "uploadImage";
	
	showStatus("loading",1);
	document.forms['uploadImage_form'].submit();
  };


function deleteFile()
 {

 if (document.forms['uploadImage_form'].filenames.options.length == 0)
   return;
   
   
   var isSelected = 0; 
   for(i=document.forms['uploadImage_form'].filenames.options.length-1;i>=0;i--)
    if(document.forms['uploadImage_form'].filenames.options[i].selected)
	  isSelected = 1;
	
	if (isSelected == 0)
	 return;
	  
   
   
   document.forms['uploadImage_form'].uploadAction.value = "deleteFile";
  var f = document.forms['uploadImage_form'].filenames.options[document.forms['uploadImage_form'].filenames.options.selectedIndex].value;
	 
	 
	 document.forms['uploadImage_form'].filename.value = f;
	 document.forms['uploadImage_form'].submit();
	  
 };
 

function deleteFilename(){
  var i;
  if (document.forms['uploadImage_form'].filenames.options.length == 0)
   return;
   
  var isSelected = 0; 
   for(i=document.forms['uploadImage_form'].filenames.options.length-1;i>=0;i--)
    if(document.forms['uploadImage_form'].filenames.options[i].selected)
	  isSelected = 1;
	
	if (isSelected == 0)
	 return;
	
   
  for(i=document.forms['uploadImage_form'].filenames.options.length-1;i>=0;i--)
   {
    if(document.forms['uploadImage_form'].filenames.options[i].selected)
     document.forms['uploadImage_form'].filenames.remove(i);
    };
	
	document["large_image"].src = "../images/icons/no_image.jpg";
 };
 
 
 function clearList(){
  var i;
  for(i=document.forms['adaugare_produs'].filenames.options.length-1;i>=0;i--)
   {
     document.forms['adaugare_produs'].filenames.remove(i);
    };
 };
 
 
