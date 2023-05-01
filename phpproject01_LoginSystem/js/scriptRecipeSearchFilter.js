//Welcome message
var i = 0;
var txt = "Welcome";
var speed = 100;

function typeWriter() {
    if(i<txt.length){
        document.getElementById("demo").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
}
//

// //Filter dropdown
// var expanded = false;
// function showCheckboxes() {
//     var checkboxes = document.getElementById("checkboxes");
//     if(!expanded) {
//         checkboxes.style.display = "block";
//         expanded = true;
//     }
//     else {
//         checkboxes.style.display = "none";
//         expanded = false;
//     }
// }
// //


//API search/URL builder

const form = document.querySelector('form');
const searchResult = document.querySelector('.search');
const container = document.querySelector('.container');
let userQuery = '';

let dietLabels = [];
let cuisineType = [];
let mealType = [];
// let minCal = '';
// let maxCal = '';

form.addEventListener('submit', (e)=>{
        e.preventDefault();

        userQuery = e.target.querySelector('input').value;
        console.log(userQuery);

        dietLabels = e.target.querySelector('select[name="dietLabels"]').value;
        console.log(dietLabels);

        cuisineType = e.target.querySelector('select[name="cuisineType"]').value;
        console.log(cuisineType);

        mealType = e.target.querySelector('select[name="mealType"]').value;
        console.log(mealType);

        // minCal = document.querySelector('input[name="minCalories"]');
        // maxCal = document.querySelector('input[name="maxCalories"]');

    sendSearchRequest()
})

function createContent(results){
    let initialContent = '';
    // results.map(result => {
        initialContent += 
        `<div class="item">
        <img src="${results[3]}" alt="">
        <div class="flex-container">
            <h1 class='title'>${results[0]}</h1>
            <a class='view-btn' href='${result[2]}'>View</a>
        </div>
    </div>`
    })

    searchResult.innerHTML = initialContent;
}

function sendSearchRequest()
{
    let request = new XMLHttpRequest();
    request.open("POST","../includes/searchDB.inc.php",true);
    request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    request.onreadystatechange= function ()
    {

        if (this.status == 200)
        {
            HandleSignupResponse(this.responseText);
        }
        else {
            alert("There was an issue with the search recipe request.");
        }
    }
    request.send("type=search&query="+userQuery+"&dietLabels="+dietLabels+"&cuisineType="+cuisineType+"&mealType="+mealType);
}

function HandleSignupResponse(response)
{
    if(response === 0) {
        alert("DB search Fail.")
    }
    else{
        alert("DB search Sucessful!");
        const myObj = JSON.parse(response);
        const results = Object.values(myObj);
        console.log(results);
        createContent(results);
    }
}
