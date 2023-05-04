<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Register</title>
        <?php
			include_once 'header.php';
		?>

  <div class="auth-content">

    <!-- <form action="register.html" method="post"> -->
	<section class="signup-form">
      <h2 class="form-title">Create account</h2>

      <!-- <div class="msg error">
        <li>Username required</li>
      </div> -->

	  <div>
        <label>Full Name</label>
        <input type="text" id="ajaxTextName" class="text-input">
      </div>
      <div>
        <label>Email</label>
        <input type="email" id="ajaxTextEmail" class="text-input">
      </div>
	  <div>
        <label>Username</label>
        <input type="text" id="ajaxTextUser" class="text-input">
      </div>
      <div>
        <label>Password</label>
        <input type="password" id="ajaxTextPwd" class="text-input">
      </div>
      <div>
        <label>Password Confirmation</label>
        <input type="password" id="ajaxTextRptPwd" class="text-input">
      </div>
      <div>
        <button type="submit" id="ajaxButton" class="btn btn-big">Sign up</button>
      </div>
      <p>Have an account? <a href="login.php">Log In</a></p>
    </section>

  </div>

  <!-- // Page Wrapper -->
 	<?php
		include_once 'footer.php';
	?>

<script>
  document.getElementById("ajaxButton").addEventListener('click', function() {
    const name = document.getElementById("ajaxTextName").value;
    const email = document.getElementById("ajaxTextEmail").value;
    const userName = document.getElementById("ajaxTextUser").value;
    const passWord = document.getElementById("ajaxTextPwd").value;
    const rptPassWord = document.getElementById("ajaxTextRptPwd").value;
    SendSignupRequest(name,email,userName,passWord,rptPassWord); }, false);
</script>
</html>