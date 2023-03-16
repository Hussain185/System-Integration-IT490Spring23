<?php
  include_once 'header.php';
?>

<section class="signup-form">
  <h2>Sign Up</h2>
  <div class="signup-form-form">
      <input type="text" id="ajaxTextName" placeholder="Full name...">
      <input type="text" id="ajaxTextEmail" placeholder="Email...">
      <input type="text" id="ajaxTextUser" placeholder="Username...">
      <input type="password" id="ajaxTextPwd" placeholder="Password...">
      <input type="password" id="ajaxTextRptPwd" placeholder="Repeat password...">
      <button type="submit" id="ajaxButton">Sign up</button>
  </div>
  <?php
    // Error messages
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
      }
      else if ($_GET["error"] == "invaliduid") {
        echo "<p>Choose a proper username!</p>";
      }
      else if ($_GET["error"] == "invalidemail") {
        echo "<p>Choose a proper email!</p>";
      }
      else if ($_GET["error"] == "passwordsdontmatch") {
        echo "<p>Passwords doesn't match!</p>";
      }
      else if ($_GET["error"] == "none") {
        echo "<p>You have signed up!</p>";
      }
    }
  ?>
</section>

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
