<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Sign In</title>
        <?php
			include_once 'header.php';
		?>
		
  <div class="auth-content">

    <!-- <form action="register.html" method="post"> -->
	<section class="signup-form">
      <h2 class="form-title">Register</h2>

      <!-- <div class="msg error">
        <li>Username required</li>
      </div> -->

	  <div>
        <label>Username</label>
        <input type="text" id="ajaxTextUser" class="text-input">
      </div>
      <div>
        <label>Password</label>
        <input type="password" id="ajaxTextPwd" class="text-input">
      </div>
      <div>
        <button type="submit" id="ajaxButton" class="btn btn-big">Register</button>
      </div>
      <p>Or <a href="signup.php">Sign In</a></p>
    </section>

  </div>
  
  <!-- // Page Wrapper -->
 	<?php 
		include_once 'footer.php';
	?>

</html>
