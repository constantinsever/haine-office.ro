var xmlhttp,command, timer_req, url, parameter, active, refresh_count;


refresh_count = 0;




function like(product_id)
{
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }
  
   
 url = "like.php";
 url=url+"?product_id="+product_id;

 
 //url=url+"&sid="+Math.random();

 xmlhttp.onreadystatechange=displayResultLike;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
}




function displayResultLike()
{
 if (xmlhttp.readyState==4)
 {
   document.getElementById("rating_php_output").innerHTML = xmlhttp.responseText;
 }
}


function displayResultDeleteRefreshCart()
{
 if (xmlhttp.readyState==4)
 {
   document.getElementById("delete_refresh_cart_php_output").innerHTML = xmlhttp.responseText;
 }
}



function AddToCart(isOK)
{
 if (isOK == '0')
  {
	  if (!confirm("Stoc insuficient, produsul va fi comandat imediat la furnizor. \n Doriti sa il comandati, totusi ?"))
	   return;
    };
 
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }
  
   
 url = "addToCart.php";

 color = document.getElementById('color_list').value;
 size = document.getElementById('size_list').value;
 
 
 url=url+"?product_id="+document.getElementById('product_id_main').value;
 url=url+"&color="+color;
 url=url+"&size="+size;
 


 
 //url=url+"&sid="+Math.random();

 xmlhttp.onreadystatechange=displayResultAddToCart;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
}



function addToWishList(product_id)
{
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }
  
   
 url = "addToWishlist.php";
 url=url+"?product_id="+product_id;

 
 //url=url+"&sid="+Math.random();

 xmlhttp.onreadystatechange=displayResultAddToCart;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
}



function displayResultAddToCart()
{
 if (xmlhttp.readyState==4)
 {
   document.getElementById("show_details_php_output").innerHTML = xmlhttp.responseText;
 }
}



function delete_refresh_cart(action, product_id_cart){
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }
  
 
 url = "delete_refresh_cart.php";
 url=url+"?action="+action;
 url=url+"&product_id_cart="+product_id_cart;
 
var  quantity_edit_id = 'quantity_' + product_id_cart;
 url=url+"&quantity="+document.getElementById(quantity_edit_id).value;

 var  color_list_id = 'color_list_'+product_id_cart;

 var size_list_id = 'size_list_'+product_id_cart;
 url=url+"&color="+document.getElementById(color_list_id).value;	 
 url=url+"&size="+document.getElementById(size_list_id).value;	 
 

 
 //url=url+"&sid="+Math.random(); !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

 xmlhttp.onreadystatechange=displayResultDeleteRefreshCart;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

}


function delete_refresh_wishlist( product_id_wishlist){
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }
  

 url = "delete_refresh_wishlist.php?product_id_wishlist="+product_id_wishlist;

  
 //url=url+"&sid="+Math.random(); !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

 xmlhttp.onreadystatechange=displayResultDeleteWishlist;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);

}


function displayResultDeleteWishlist()
{
 if (xmlhttp.readyState==4)
 {
   document.getElementById("delete_refresh_wishlist_php_output").innerHTML = xmlhttp.responseText;
 }
}



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


function showProducts(category, index){
 document.select_category.hiddenCategory.value = category;
 document.select_category.hiddenIndex.value = index;
 
 document.select_category.submit();
}


function searchProducts(criteria, index){

document.search_form.searchCriteria.value = criteria;
document.search_form.searchIndex.value = index;
 document.search_form.submit();

}


  function changeImage(s){

    var largeImage;

	if (document.images)
	{
  	  	  
	 
	   largeImage = new Image();
       largeImage.src = "/image_uploads/"+s;
	   
      document["full_image"].src = largeImage.src;
	  document.getElementById('large_image_layer').style.visibility='visible';
	};
 }




function place_order()
{
  // procesare forma ...
  document.forms['placeOrder_form'].submit();
}



