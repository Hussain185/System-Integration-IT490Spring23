<!--Started and modified from a template by Code For Life-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='css/styleRecipeSearchFilter.css'>
    <title>Recipe Search</title>
</head>
<body onload='typeWriter()'>
    <section>
        <div class="container">
            <h1 class="app-title">Recipe Search</h1>
            <form>
                <input type='text' placeholder="Search for recipes">

                <!-- add multiple="multiple" -->
                <select name="dietLabels">
                    <option value="">All Diets</option>
                    <option value="balanced">Balanced</option>
                    <option value="high-fiber">High-Fiber</option>
                    <option value="high-protein">High-Protein</option>
                    <option value="low-carb">Low-Carb</option>
                    <option value="low-fat">Low-Fat</option>
                    <option value="low-sodium">Low-Sodium</option>
                </select>

                <select name="mealType">
                    <option value="">All Meals</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Snack">Snack</option>
                    <option value="Teatime">Teatime</option>
                </select>

                <select name="cuisineType">
                    <option value="">All Cuisines</option>
                    <option value="American">American</option>
                    <option value="British">British</option>
                    <option value="Chinese">Chinese</option>
                    <option value="French">French</option>
                    <option value="Indian">Indian</option>
                    <option value="Italian">Italian</option>
                    <option value="Japanese">Japanese</option>
                </select>
                <!-- <div class="calories">
                    <input
                        class="minCal"
                        type="number"
                        name="minCalories"
                        min="0"
                        step="100"
                        placeholder="Min Calories"
                    />
                    <input
                        class="maxCal"
                        type="number"
                        name="maxCalories"
                        max="5000"
                        step="100"
                        placeholder="Max Calories"
                    />
                </div> -->
            </form>

            <!--Filter dropdown-->
            <!-- <form2>
                <div class="multiselect">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select>
                            <option>Select and Option</option>
                        </select>
                            <div class="overSelect"></div>
                    </div>
                    <div id="checkboxes">
                            <label><input type="checkbox" value="low-carb"/>Low-Carb</label>
                            <label><input type="checkbox" id="2"/>Two</label>
                            <label><input type="checkbox" id="3"/>Three</label>
                    </div>
               </div>
            </form2> -->
            
            <p id="demo"></p>
            <div class="search">
                <!-- <div class="item">
                    <img src="https://images.pexels.com/photos/230743/pexels-photo-230743.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
                    <div class="flex-container">
                        <h1 class='title'>Here's a recipe</h1>
                        <a class='view-btn' href='#'>View recipe</a>
                    </div>
                    <p class='recipe-desc'>Calories: 200</p>
                </div> -->
            </div>
        </div>
    </section>
    <script src='scriptRecipeSearchFilter.js'></script>
</body>
</html>
