function SendEventRequest(title, description, startDate, length, color)
{
    let eventRequest = new XMLHttpRequest();
    eventRequest.open("POST","includes/login.inc.php",true);
    eventRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    eventRequest.onreadystatechange= function ()
    {

        if (this.status === 200)
        {
            HandleEventResponse(this.responseText);
        }
        else {
            alert("There was an issue with the request.");
        }
    }
    eventRequest.send("type=event&title="+title+"&desc="+description+"&startDate="+startDate+"&length="+length+"&color="+color);
}

function HandleEventResponse(response)
{
    if(response === 0) {
        alert("Event Creation Failed.")
    }
    else{
        alert("Event Created");
    }
}