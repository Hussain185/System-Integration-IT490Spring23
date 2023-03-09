<?php
  include_once 'header.php';
?>

<section class="signup-form">
  <h2>Log In</h2>
  <div class="signup-form-form">
      <input type="text" id="ajaxTextUser" value="john123">
      <input type="password" id="ajaxTextPwd" value="password123">
      <button type="submit" id="ajaxButton">Sign up</button>
  </div>
  <?php
  /*
    // Error messages
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "emptyinput") {
        echo "<p>Fill in all fields!</p>";
      }
      else if ($_GET["error"] == "wronglogin") {
        echo "<p>Wrong login!</p>";
      }
    }
    */
  ?>
</section>

<?php
  include_once 'footer.php';
?>
<script>
  document.getElementById("ajaxButton").onclick = () =>
  {
    const userName = document.getElementById("ajaxTextUser").value;
    const passWord = document.getElementById("ajaxTextPwd").value;
    SendLoginRequest(userName,passWord);
  }
</script>
</html>

