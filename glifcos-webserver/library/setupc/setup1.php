<!--
        THIS FILE IS PART OF THE GLIFCOS PROJECT BY @HOTFIREYDEATH.

        THIS PROJECT IS LICENSED UNDER THE MIT LICENSE (MIT). A COPY OF 
        THE LICENSE IS AVAILABLE WITH YOUR DOWNLOAD (LICENSE.txt).
        
              ___                                     ___           ___           ___           ___     
             /\__\                                   /\__\         /\__\         /\  \         /\__\    
            /:/ _/_                     ___         /:/ _/_       /:/  /        /::\  \       /:/ _/_   
           /:/ /\  \                   /\__\       /:/ /\__\     /:/  /        /:/\:\  \     /:/ /\  \  
          /:/ /::\  \   ___     ___   /:/__/      /:/ /:/  /    /:/  /  ___   /:/  \:\  \   /:/ /::\  \ 
         /:/__\/\:\__\ /\  \   /\__\ /::\  \     /:/_/:/  /    /:/__/  /\__\ /:/__/ \:\__\ /:/_/:/\:\__\
         \:\  \ /:/  / \:\  \ /:/  / \/\:\  \__  \:\/:/  /     \:\  \ /:/  / \:\  \ /:/  / \:\/:/ /:/  /
          \:\  /:/  /   \:\  /:/  /   ~~\:\/\__\  \::/__/       \:\  /:/  /   \:\  /:/  /   \::/ /:/  / 
           \:\/:/  /     \:\/:/  /       \::/  /   \:\  \        \:\/:/  /     \:\/:/  /     \/_/:/  /  
            \::/  /       \::/  /        /:/  /     \:\__\        \::/  /       \::/  /        /:/  /   
             \/__/         \/__/         \/__/       \/__/         \/__/         \/__/         \/__/    
-->
<!-- <div class="container"> -->
<br>
<div class="w3-card-4" style="width:100%">
<header class="w3-container w3-blue">
  <h1>Welcome to Glifcos!</h1>
</header>
<div class="w3-container">
  
  <div class="w3-container w3-border-left">
  <p>
    I've detected that this is a first-time installation.
    Let's get you setup quickly!
  </p>
  </div>
  
  <br>
  <br>
  Step 1: Verify Server<br>
  In order for Glifcos to work, this webserver needs to be able to collaborate with
  it's target server. If you have setup the plugin correctly, simply restart your 
  server. This page will automatically show your server data once we've recieved it.
  
  <br>
  <br>
  
  <?php
  if (!is_file($_COOKIE["cl"]."/grudge.json")){
      echo '
      
      <div class="w3-container w3-red">
      <p>
      <strong><i class="fa fa-exclamation-triangle"></i> Server Not Found</strong><br>
      Please try again, and refresh the page to update.
      </p>
      </div> 
      <br>
            ';
  }
  else{
      $data = json_decode(file_get_contents($_COOKIE["cl"]."/grudge.json"), true);
      echo '<script>document.cookie="setup=2;";</script>';
      echo '
      <div class="w3-container w3-blue">
      <p>
      <strong><i class="fa fa-check"></i> Server Detected</strong><br>
      We have detected your server. Please make sure the data below is correct.<br>
      <span class="w3-tag w3-green">'.$data["ip"].":".$data["port"].'</span>
      </p>
      </div>
      <br>
      <a href="index.php" class="w3-btn w3-blue" role="button">Next Step</a>
      ';
  }
  ?>
<!-- </div> -->