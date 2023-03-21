<?php
  include_once 'includes/functions.inc.php';
?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Font Awesome -->
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Candal|Lora"
            rel="stylesheet">

        <!-- Custom Styling -->
        <link rel="stylesheet" href="css/style.css">

        <!-- Admin Styling 
        <link rel="stylesheet" href="css/admin.css">
		-->
    </head>

    <body>
		<header>
			<div class="logo">
				<h1 class="logo-text"><span>Compile</span>Cart</h1>
			</div>
			<i class="fa fa-bars menu-toggle"></i>
			<ul class="nav">
				<li><a href="index.php">Home</a></li>
				<li><a href="index.php">About</a></li>
				<?php
          
				if (isset($_COOKIE['username'])) {
					echo "<li>";
						echo "<a href='#'>Services";
							echo "<i class='fa fa-chevron-down' style='font-size: .8em;'></i>";
						echo "</a>";
						echo "<ul>";
							echo"<li><a href='create.php'>Create Food Post!</a></li>";
							echo "<li><a href='indexRecipeSearchFilter.php'>Search Recipe!</a></li>";
						echo "</ul>";	
					echo "</li>"; 
					echo "<li><a href='logout.html' class='logout'>Logout</a></li>";
				}
				else {
					echo "<li><a href='signup.php'>Sign Up</a></li>";
					echo "<li><a href='login.php'>Login</a></li>";
				}
				?>
			</ul>
		</header>
