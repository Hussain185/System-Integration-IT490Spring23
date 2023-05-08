 <?php
require_once "dbh.inc.php";
require_once "functions.inc.php";

// Establish database connection
$conn = dbConnection();

// Call the getPosts function defined in functions.php
$post = getPost($conn, $_GET['post_id']);

// Encode the results as JSON and send them back to the client
echo json_encode($post);

