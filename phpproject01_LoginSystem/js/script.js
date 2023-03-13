// Change nav menu color if on that page!
let pageUrl = window.location.pathname;
let getNav = document.querySelectorAll("nav div ul li a");

for (let i = 0; i < getNav.length; i++) {
  // Get URL info
  let pageUrlName = pageUrl.split("/");
  let pageUrlLength = pageUrlName.length - 1;
  // Get links info
  let pageNav = getNav[i].pathname;
  let pageNavName = pageNav.split("/");
  let pageNavLength = pageNavName.length - 1;
  let pageFinalName = pageNavName[pageNavLength];
  let pageNavExists = pageUrl.includes(pageFinalName);
  // Change links color
  if (pageNavExists == true) {
    getNav[i].style.cssText = "color: #31a6ff;";
  }
  else if (pageUrlName[pageUrlLength] == "") {
    getNav[0].style.cssText = "color: #31a6ff;";
  }
}
function setCookie(cname, cvalue, exminutes) {
  const d = new Date();
  d.setTime(d.getTime() + (exminutes*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = '"' + cname + '=' + cvalue + ';' + expires + ';path=/"';
}
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function HandleLoginResponse(response)
{
	if(response == "0") {
		alert("Login Fail.")
	}
	else{
		alert("Login Sucessful!");
		const myObj = JSON.parse(response);
		var name = myObj.username;
		var session = myObj.sessionId;
		var exp = 10;
		setCookie(name,session,exp);
	}
}

function SendLoginRequest(username,password)
{
	var request = new XMLHttpRequest();
	request.open("POST","includes/login.inc.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange= function ()
	{
		
		if (this.status == 200)
		{
			HandleLoginResponse(this.responseText);	   
		}		
		else {
          		alert("There was an issue with the request.");
        	}
	}
	request.send("type=login&uname="+username+"&pword="+password);
}
