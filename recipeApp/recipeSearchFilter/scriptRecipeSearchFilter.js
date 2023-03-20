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

const ID = "b14f1b2d";
const key = "b7d53cad8c74e29b857054d820b2ab4c";

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

    fetchData();
})

async function fetchData(){
    let baseURL = `https://api.edamam.com/search?q=${userQuery}&app_id=${ID}&app_key=${key}`; //&diet=${dietLabels}&cuisineType=${cuisineType}&mealType=${mealType}&calories=${minCal}-${maxCal}`;   //&diet=${dietLabels}
    
    if (dietLabels.length) {
        baseURL += "&diet=" + dietLabels;
    }

    if (mealType.length) {
        baseURL += "&mealType=" + mealType;
    }

    if (cuisineType.length) {
        baseURL += "&cuisineType=" + cuisineType;
    }

    const response = await fetch(baseURL);
    const data = await response.json();
    createContent(data.hits);
    console.log(data);
}

function createContent(results){
    let initialContent = '';
    results.map(result => {
        initialContent += 
        `<div class="item">
        <img src="${result.recipe.image}" alt="">
        <div class="flex-container">
            <h1 class='title'>${result.recipe.label}</h1>
            <a class='view-btn' href='${result.recipe.url}'>View</a>
        </div>
        <p class='recipe-desc'>Calories: ${result.recipe.calories.toFixed(2)}</p>
    </div>`
    })

    searchResult.innerHTML = initialContent;
}

function sendSearchRequest(label)
{
    let request = new XMLHttpRequest();
    request.open("POST","searchDB.inc.php",true);
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
    request.send("type=search&label="+label);
}

function HandleSignupResponse(response)
{
    if(response === 0) {
        alert("DB search Fail.")
    }
    else{
        alert("DB search Sucessful!");
    }
}