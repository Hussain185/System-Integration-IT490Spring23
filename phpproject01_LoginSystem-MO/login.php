<?php session_start(); ?>

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
      <h2 class="form-title">Login</h2>

      <!-- <div class="msg error">
        <li>Username required</li>
      </div> -->

	  <div>
        <label>Username</label>
        <input type="text" id="ajaxTextUser" class="text-input" name="ajaxTextUser">
      </div>
      <div>
        <label>Password</label>
        <input type="password" id="ajaxTextPwd" class="text-input">
      </div>
      <div>
        <button type="submit" id="ajaxButton" class="btn btn-big">Log In</button>
      </div>
      <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </section>

  </div>

  <!-- // Page Wrapper -->
 	<!-- <?php
		include_once 'footer.php';

    // function sendUserInfo() {
    //   jQuery.ajax({
    //           url: "2fa.php",
    //           data:'ajaxTextUser='+$("#ajaxTextUser").val(),
    //           type: "POST",
    //           success:function(data){
    //               $("#auth-content").html(data);
    //           },
    //           error:function (){}
    //       });
    // }
	?> -->
<script>
  document.getElementById("ajaxButton").addEventListener('click', function() {
    const userName = document.getElementById("ajaxTextUser").value;
    const passWord = document.getElementById("ajaxTextPwd").value;
    SendLoginRequest(userName,passWord); }, false);
</script>
</html>