var xmlhttp,command, timer_req, url, parameter, active, refresh_count;


function createAccount(){
	
	

	if (document.forms['createAccountForm'].create_username.value.length < 4) 
	 {
		  alert("Introduceti un nume de utilizator valid, de minim 4 caractere")
		  return;
	 };
	
	if ((document.forms['createAccountForm'].password1.value.length < 5) || (document.forms['createAccountForm'].password1.value != document.forms['createAccountForm'].password2.value) ) 
	 {
		  alert("Parola trebuie sa aiba mimim 5 caractere.\nParola trebuie introdusa identic in cele doua campuri de parola.")
		  return;
	 };

	
	
if (!document.forms['createAccountForm'].accept_politica.checked)
 {
	  alert("Nu puteti crea cont, daca nu sunteti de acord cu politica acestui magazin.")
	  return;
 };



document.createAccountForm.submit();

};



function login()
{
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }


 login_username = document.getElementById('username').value;
 login_password = document.getElementById('password').value;

  
 url = "loginExec.php";
 url=url+"?username="+login_username;
 url = url+"&password="+login_password;
 
 
 //url=url+"&sid="+Math.random();

 xmlhttp.onreadystatechange=displayResult;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
 
 
}


function logout(cwd)
{
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }


  
 url = "logoutExec.php";
 
 //url=url+"&sid="+Math.random();

 xmlhttp.onreadystatechange=displayResult;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
 
 
}



function displayResult()
{
 var i;
 if (xmlhttp.readyState==4)
 {
  i = xmlhttp.responseText.search("bad password");	  
   if ( i != -1)
    alert("Parola gresita, va rugam verificati.");
	else
     {
		 document.getElementById("login_php_output").innerHTML = xmlhttp.responseText;

	 }
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



function newAccount(){
	
	
	
	if (document.forms['create_account'].username.value.length < 5) 
	 {
		  alert("Introduceti un nume de utilizator valid, de minim 5 caractere")
		  return;
	 };
	
	if ((document.forms['create_account'].password1.value.length < 5) || (document.forms['create_account'].password1.value != document.forms['create_account'].password2.value) ) 
	 {
		  alert("Parola trebuie sa aiba mimim 5 caractere.\nParola trebuie introdusa identic in cele doua campuri de parola.")
		  return;
	 };
	
		
 xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }

 url = "code/create_account.php";
 url=url+"?username="+document.forms['create_account'].username.value;

 url=url+"&password="+document.forms['create_account'].password1.value;
 url=url+"&fullname="+document.forms['create_account'].fullname.value;
 url=url+"&address="+document.forms['create_account'].address.value;
 url=url+"&email="+document.forms['create_account'].email.value;
 url=url+"&phone="+document.forms['create_account'].phone.value;
 

 
 xmlhttp.onreadystatechange=displayResult;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
	

};



function recoverPassword(){
	
	xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }

 url = "code/create_account.php";
 url=url+"?username="+document.forms['create_account'].username.value;

 url=url+"&password="+document.forms['create_account'].password1.value;
 
 xmlhttp.onreadystatechange=displayResult;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
	

	
};


function abonareNewsletter()
 {
  xmlhttp=GetXmlHttpObject();
 if (xmlhttp==null)
  {
   alert ("Browser does not support HTTP Request");
   return;
  }

 url = "abonareNewsletter_exec.php";
 email =  document.getElementById('emailNewsletter').value;
 if (email == "")
  {
	alert("Va rugam introduceti o adresa de email valida");
	return;
  };
 
 url=url+"?email="+email;
 
 xmlhttp.onreadystatechange=displayResultAbonareNewletter;
 xmlhttp.open("GET",url,true);
 xmlhttp.send(null);
 
	 
 };


function displayResultAbonareNewletter()
{
 if (xmlhttp.readyState==4)
 {
  document.getElementById("aaa").innerHTML = xmlhttp.responseText;
  }
}
