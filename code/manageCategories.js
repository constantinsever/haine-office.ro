var xmlhttp,command, timer_req, url, parameter, active, refresh_count, old_name;
    
  html_create = "  <form name=\"form_manage_category\"> \
  <table  width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"2\"> \
   <tr> \
    <td colspan=\"3\"  bgcolor=\"#E9E9E9\" class=\"bold\" align=\"center\">Adaugare categorie </td> \
   </tr>\
   <tr><td></td></tr>\
  <tr>\
    <td class=\"bold\">Numele categoriei :</td>\
    <td><input type=\"text\" name=\"category_name\" class=\"box_100\"/></td></tr>\
	<tr><td></td></tr>\
  <tr><td ><input type=\"button\" value=\"Adaugare\" class=\"box_100\" onClick=\"addCategory()\"/></td>\
	<td ><input type=\"button\"  value=\"Anulare\" class=\"box_100\" onClick=\"document.getElementById('form_layer').style.visibility = 'hidden'\"/>\
	</td></tr>\
</table></form>";

 
 html_rename_1 = " <form name=\"form_manage_category\"> \
 <table  width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"2\"> \
   <tr> \
    <td colspan=\"3\"  bgcolor=\"#E9E9E9\" class=\"bold\">Redenumire categorie </td> \
   </tr>\
   <tr><td></td></tr>\
  <tr>\
    <td class=\"bold\">Noul nume  : </td>\
    <td><input type=\"text\" name=\"category_name\" class=\"box_100\" value=\"";

 html_rename_2 = "\"/></td></tr>\
    <tr><td></td></tr>\
    <tr><td ><input type=\"button\" value=\"Redenumire\" class=\"box_100\"  onClick=\"renameCategory()\"/></td>\
	<td ><input type=\"button\"  value=\"Anulare\" class=\"box_100\" onClick=\"document.getElementById('form_layer').style.visibility = 'hidden'\"/> \
    </td></tr>\
</table> </form>";

 html_delete_1 = " <table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"2\"> \
   <tr> \
    <td colspan=\"3\"  bgcolor=\"#E9E9E9\" class=\"bold\">Stergere categorie </td> \
   </tr>\
   <tr><td></td></tr>\
  <tr>\
    <td colspan=\"2\" class=\"bold\">Stergeti categoria ";
html_delete_2 = " </td></tr>\
   <tr><td></td></tr>\
    <tr><td align=\"center\"><input type=\"button\" value=\"Da\" class=\"box_100\" onClick=\"deleteCategory()\"/></td>\
	<td align=\"center\"><input type=\"button\"  value=\"Anulare\" class=\"box_100\" onClick=\"document.getElementById('form_layer').style.visibility = 'hidden'\"/> \
	</td></tr> \
</table>";


html_backup = " <table width=\"100%\" border=\"0\" cellspacing=\"5\" cellpadding=\"2\"> \
   <tr> \
    <td colspan=\"3\"  bgcolor=\"#E9E9E9\">Salvare baza de date </td> \
   </tr>\
  <tr>\
    <td colspan=\"2\">Salvati baza de date in aceasta forma ?</td></tr>\
    <tr><td ><input type=\"button\" value=\"Da\" class=\"box_100\"/></td>\
	<td ><input type=\"button\"  value=\"Anulare\" class=\"box_100\" onClick=\"document.getElementById('form_layer').style.visibility = 'hidden'\"/> \
	</td><input type=\"hidden\" name=\"operation\" value=\"rename\"> \
  </tr>\
</table>";

function showForm(type)
{
	if (type == 'add')
		    {
				
			 document.getElementById('form_layer').innerHTML = html_create;
			 document.getElementById('form_layer').style.visibility = 'visible';
			}
	
	if (type == 'rename')			
        	{
				i = document.getElementById('category_list').selectedIndex; 
				if (i == -1)
				 alert("Selectati o categorie !")
				 else
                 {
				   value = document.getElementById('category_list').options[i].value.split(':');
                   old_name = value[0]; 
				   s = html_rename_1 + old_name + html_rename_2 ;
				   document.getElementById('form_layer').innerHTML = s;
				   document.getElementById('form_layer').style.visibility = 'visible';
				 };
			};
	if (type == 'delete')			
        	{
				i = document.getElementById('category_list').selectedIndex; 
				if (i == -1)
				 alert("Selectati o categorie !")
				 else
                 {
				   category = document.getElementById('category_list').options[i].value;
				   data = category.split(":");
				   s = html_delete_1 + '"'+ data [0]+ "\" cu toate<br>subcateogriile si produsele incluse ?" + html_delete_2 ;
				   document.getElementById('form_layer').innerHTML = s;
				   document.getElementById('form_layer').style.visibility = 'visible';
				 };
			};
	if (type == 'backup')			
        	document.getElementById('form_layer').innerHTML = html_backup;
			
};


function showCategories()
 {
	 // schimbare categorie selectata din listBox
  xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
   {
    alert ("Browser does not support HTTP Request");
    return;
   }

 
 url = "/code/manage_exec.php";
 url=url+"?action=show_categories";

 xmlhttp.onreadystatechange=displayShowCategories;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

 }
 
 
 
 
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
 
 
 function addCategory()
 {
  var commandString;
  var listString = '';
  
  xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
   {
    alert ("Browser does not support HTTP Request");
    return;
   }

 document.getElementById('form_layer').style.visibility = 'hidden';
var d = new Date();
var categoryID = d.getDate().toString() + d.getMonth().toString() + d.getFullYear().toString() + d.getHours().toString() + d.getMinutes().toString() + d.getSeconds().toString();


   i = document.getElementById('category_list').selectedIndex;   	  
   selectedItem = document.getElementById('category_list').options[i].value;
   if (i == -1)
    return;
   parentData = selectedItem.split(':');
  
   childOf = parentData[1]; // parintele noii categorii este ID-ul categoriei selectate
   commandString = document.forms['form_manage_category'].category_name.value +':' + categoryID +':' + childOf;

 
   
url = "manage_exec.php";
 url=url+"?action=addCategory";
 url=url+"&commandString="+commandString;

xmlhttp.onreadystatechange=displayAddDeleteRenameCategory;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

}

function addModifyProduct(action, product_id)
 {
	 i = document.getElementById('category_list').selectedIndex;   	  
	   if (i == -1)
        return;
	 
	document.getElementById('action').value=action;
	
	
      selectedItem = document.getElementById('category_list').options[i].value;
      data = selectedItem.split(':');
	  document.getElementById('id_categorie').value=data[1]; // categoria parinte pentru noul produs
      document.getElementById('id_produs').value=product_id;
	 
	document.forms['manage_form'].submit();
 };
 

 
 
 function deleteCategory()
 {
	 // schimbare categorie selectata din listBox
  xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
   {
    alert ("Browser does not support HTTP Request");
    return;
   }

   i = document.getElementById('category_list').selectedIndex;   	  
   selectedItem = document.getElementById('category_list').options[i].value;
   /// verificare daca e selectat ceva ...
   data = selectedItem.split(':');
   
 url = "manage_exec.php";
 url=url+"?action=deleteCategory";
 url=url+"&category_id="+data[1];
 
 document.getElementById('form_layer').style.visibility = 'hidden';
 xmlhttp.onreadystatechange=displayAddDeleteRenameCategory;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

 }
 
function displayAddDeleteRenameCategory()
{
 if (xmlhttp.readyState==4)
 {
  document.getElementById("manage_php_output").innerHTML = xmlhttp.responseText;
 
 }
}
  
function renameCategory()
 {
	 // schimbare categorie selectata din listBox
  xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
   {
    alert ("Browser does not support HTTP Request");
    return;
   }
  document.getElementById('form_layer').style.visibility = 'hidden';
 url = "manage_exec.php";
 url=url+"?action=renameCategory";
 url=url+"&old_name="+old_name;
 
 new_name = document.forms['form_manage_category'].category_name.value;
 url=url+"&new_name="+new_name;
 

 xmlhttp.onreadystatechange=displayAddDeleteRenameCategory;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);


 }
 
 
 function displayShowCategories()
{
 if (xmlhttp.readyState==4)
   document.getElementById("manage_php_output").innerHTML = xmlhttp.responseText;
   
}
 


function showCategoryProducts()
 {
  xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
   {
    alert ("Browser does not support HTTP Request");
    return;
   }

 
  i = document.getElementById('category_list').selectedIndex;   	  
   selectedItem = document.getElementById('category_list').options[i].value;
   /// verificare daca e selectat ceva ...
   data = selectedItem.split(':');
   
   document.getElementById('category_name').innerHTML= "Categorie selectata : " + data[0];
     
   
 
 url = "manage_exec.php";
 url=url+"?action=showCategoryProducts";
 url=url+"&category="+data[1];
 

 xmlhttp.onreadystatechange=showCategoryProducts_output;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

 }
 

function showCategoryProducts_output()
{
 if (xmlhttp.readyState==4)
 {
	
     document.getElementById("show_category_products").innerHTML = xmlhttp.responseText;

 }
}



 function deleteProduct(product_id, titlu)
  {
   s = "Doriti stergerea produsului \n \"" + titlu+ "\" ? ";
	 if ( !confirm(s))
	  return;
	 
  xmlhttp=GetXmlHttpObject();
  if (xmlhttp==null)
   {
    alert ("Browser does not support HTTP Request");
    return;
   }

  
 url = "manage_exec.php";
 url=url+"?action=deleteProduct";
 url=url+"&product_id="+product_id;
 
  i = document.getElementById('category_list').selectedIndex;   	  
  selectedItem = document.getElementById('category_list').options[i].value;
   data = selectedItem.split(':');

 url=url+"&category="+data[1];
 
 

 xmlhttp.onreadystatechange=showCategoryProducts_output;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
	 
 };




function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
{
// code for IE7+, Firefox, Chrome, Opera, Safari
return new XMLHttpRequest();
}
if (window.ActiveXObject)
{
// code for IE6, IE5
 return new ActiveXObject("Microsoft.XMLHTTP");
}
return null;
}



function displayResultManageObjects()
{
 if (xmlhttp.readyState==4)
 {
   document.getElementById("manage_products_php_output").innerHTML = xmlhttp.responseText;
//   document.getElementById('hiddenCurrentIndex').value
 }
}





function searchProducts(criteria, category, index){
	
 
 if (criteria != "0") // apelare din script
  document.getElementById('searchCriteria').value = criteria;

 document.getElementById('searchCategory').value = category;
 document.getElementById('searchIndex').value = index;
 
 document.search_form.submit();

}


 



