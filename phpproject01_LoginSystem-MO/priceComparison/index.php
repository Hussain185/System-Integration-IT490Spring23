<a href="../index.php">HOME</a>
<?php
    //session_start();
    require '../includes/dbh.inc.php';
    include('tasks.php');
    $obj = new Tasks;
    
    $usersUid = $_COOKIE['username'];

    if(isset($_POST['submit'])) {
        // Insert Data in the Table
        $task = $_POST['task'];
        $id = $_POST['id'];
        $created_at = $updated_at = date("Y-m-d H:i:s");

        //Update
        if(!empty($id)) {
            $sql = "UPDATE todolists set task = '".$task."', updated_at = '".$updated_at."' where id = ".$id;
            $res = $obj->executeQuery($sql);
            if($res) {
                $_SESSION['success'] = "Ingredient has been updated successfully";
            }
            else {
                $_SESSION['error'] = "Something went wrong";
            }
        }   
        else {
            $sql = "INSERT INTO todolists (task, created_at, updated_at, usersUid) VALUES ('".$task."', '".$created_at."', '".$updated_at."', '".$usersUid."')";
            //$sql = "UPDATE `schedule_list` set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}', `usersUid` =  '{$usersUid}' where `id` = '{$id}'";
            $res = $obj->executeQuery($sql);

            if($res) {
                $_SESSION['success'] = "Ingredient has been created successfully";
            }
            else {
                $_SESSION['error'] = "Something went wrong";
            }
        }
        
        session_write_close();
        header("LOCATION:index.php");
    }

    //Get all Tasks
    $tasks = $obj->getAllTasks();

    //Get Task
    $editing = false;
    if(isset($_GET['action']) && $_GET['action']  === 'edit') {
        $taskData = $obj->getTask($_GET['id']);
        $editing = true;
    }

    //Delete Task
    if(isset($_GET['action']) && $_GET['action']  === 'delete') {
        $sql = "DELETE FROM todolists WHERE id = ".$_GET['id'];
        $res = $obj->executeQuery($sql);
        if($res) {
            $_SESSION['success'] = "Task has been deleted successfully";
        }
        else {
            $_SESSION['error'] = "Something went wrong, please try again later";
        }

        session_write_close();
        header("LOCATION:index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../../css/assets/fontawesome/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css"/>
    <title>Ingredient Search and Shopping List</title>
</head>

<!-- Font Awesome -->
<link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Candal|Lora"
rel="stylesheet">

<!-- Custom Styling -->
<link rel="stylesheet" href="../css/style.css">

<body>
    <div class="split-left"></div>
      <h1>Ingredient Search</h1>
      <!-- <form onsubmit="search(event)"> -->
      <form></form>
        <input type="text" id="search-box" placeholder="Search for items" />
        <!-- <button type="submit">Search</button> -->
        <button type="submit" onclick="shoprite()">ShopRite</button>
        <button type="submit" onclick="traderjoes()">Trader Joe's</button>
        <button type="submit" onclick="walmart()">Walmart</button>
        <button type="submit" onclick="wholefoods()">Whole Foods</button>
      </form>
      <!-- <iframe id="search-results-fr" name="iframefr" width="500" height="300"></iframe>
      <iframe id="search-results-en" name="iframeen" width="500" height="300"></iframe> -->
    </div>



    <div class="split-right">
        <!--Step 1: Basic structure of Todo List-->
        <div class="container">
        <!--Step 2: Create input place and button-->
        <div id="newtask">
            <?php include('alert.php') ?>


            <h3>Shopping List</h3>
            <form action="index.php" method="post" id="taskform">
                <input type="hidden" name="id" value="<?php if($editing) { echo $taskData['id']; } ?>"  >
                <input type="text" name="task" id="task" placeholder="Next item..." value="<?php if($editing) { echo $taskData['task']; } ?>" />
                <button type="submit" name="submit" id="add"><?php if($editing) { echo "Update"; } else { echo "Add" ; } ?></button>
            </form>
        </div>

        <div id="tasks">
            <?php
                if(!empty($tasks)) {
                    foreach($tasks as $t) {
            ?>
            <div class="task">
                <span><?php echo $t['task'] ?></span>
                <a href="index.php?action=edit&id=<?php echo $t['id'] ?>" class="edit button"><i class="fa fa-edit"></i></a>
                <a onclick="return confirm('Do you want to delete this record?')" href="index.php?action=delete&id=<?php echo $t['id'] ?>" class="delete button"><i class="fa fa-trash-alt"></i></a>
            </div>
            <?php }} ?>
        </div>
        </div>
    </div>

    <br><br><br><button onclick="window.print()">Print this page</button>


    <script>
    // function search(event) {
    //   event.preventDefault();
    //   var keywords = document.getElementById("search-box").value;
    //   var url1 = "https://www.traderjoes.com/home/search?q=" + keywords;
    //   var url2 = "https://www.vistaprint.com/search?query=" + keywords;
    //   var iframefr = document.getElementById("search-results-fr");
    //   var iframeen = document.getElementById("search-results-en");
    //   iframefr.src = url1;
    //   iframeen.src = url2;
    // }

    function shoprite() {
        var keywords = document.getElementById("search-box").value;
        var urlShoprite = "https://www.shoprite.com/results?q=" + keywords;
        window.open(urlShoprite);
    }

    function traderjoes() {
        var keywords = document.getElementById("search-box").value;
        var urlTraderJoes = "https://www.traderjoes.com/home/search?q=" + keywords;
        window.open(urlTraderJoes);
    }

    function walmart() {
        var keywords = document.getElementById("search-box").value;
        var urlWalmart = "https://www.walmart.com/search?q=" + keywords;
        window.open(urlWalmart);
    }

    function wholefoods() {
        var keywords = document.getElementById("search-box").value;
        var urlWholeFoods = "https://www.wholefoodsmarket.com/search?text=" + keywords;
        window.open(urlWholeFoods);
    }
  </script>

    <script src="app.js"></script>
</body>
</html>