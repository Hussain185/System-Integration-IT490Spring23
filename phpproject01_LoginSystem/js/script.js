$(document).ready(function() {
  $(".menu-toggle").on("click", function() {
    $(".nav").toggleClass("showing");
    $(".nav ul").toggleClass("showing");
  });

  $(".post-wrapper").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    nextArrow: $(".next"),
    prevArrow: $(".prev"),
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
});

function setCookie(cusername, csessionvalue, exminutes) {
  const d = new Date();
  d.setTime(d.getTime() + (exminutes*60*1000));
  let expires = "expires="+ d.toUTCString();
  // document.cookie = '"' + cname + '=' + cvalue + ';' + expires + ';path=/"';
  document.cookie = 'username=' + cusername + ';' + expires + ';path=/';

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
	if(response == 0) {
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

function HandleSignupResponse(response)
{
	if(response == 0) {
		alert("Signup Fail.")
	}
	else{
		alert("Signup Sucessful! You can now login.");
	}
}

function SendSignupRequest(name,email,username,password,passwordrpt)
{
	var request = new XMLHttpRequest();
	request.open("POST","includes/signup.inc.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange= function ()
	{
		
		if (this.status == 200)
		{
			HandleSignupResponse(this.responseText);	   
		}		
		else {
          		alert("There was an issue with the request.");
        	}
	}
	request.send("type=signup&name="+name+"&email="+email+"&uname="+username+"&pword="+password+"&rptpword="+passwordrpt);
}

ClassicEditor.create(document.querySelector("#body"), {
  toolbar: [
    "heading",
    "|",
    "bold",
    "italic",
    "link",
    "bulletedList",
    "numberedList",
    "blockQuote"
  ],
  heading: {
    options: [
      { model: "paragraph", title: "Paragraph", class: "ck-heading_paragraph" },
      {
        model: "heading1",
        view: "h1",
        title: "Heading 1",
        class: "ck-heading_heading1"
      },
      {
        model: "heading2",
        view: "h2",
        title: "Heading 2",
        class: "ck-heading_heading2"
      }
    ]
  }
}).catch(error => {
  console.log(error);
});
