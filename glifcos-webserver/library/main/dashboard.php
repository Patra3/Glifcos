<!-- <div class="w3-container"> -->
<?php
if (!isset($_COOKIE["authchain"])){
    echo '
    <br>
    <div class="w3-card-4" style="width:100%">
    <header class="w3-container w3-blue">
      <h1>Glifcos Webserver</h1>
    </header>
    <div class="w3-container">
    <br>
    <center>
    '.file_get_contents("library/main/modalhacks/dash-login-containerhack.txt").'
    </center>
    </div>
    </div>
    ';
}
?>
<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('id01').style.display='none'" 
      class="w3-closebtn">&times;</span>
      <form class="w3-container" action="library/main/login.php" method="post">
        <p>
        <label>Username</label>
        <input class="w3-input" type="text" name="user">
        </p>
        <p>
        <label>Password</label>
        <input class="w3-input" type="password" name="pwds">
        </p>
        <button type="submit" class="w3-btn w3-blue">Login</button>
      </form>
    </div>
  </div>
</div>
<!-- </div> -->