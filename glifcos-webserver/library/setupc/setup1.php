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
<h2>Welcome to Glifcos!</h2>
<h6>I've detected that this is a first-time installation?
Well, let's get you setup quickly!</h6>
<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="10"
  aria-valuemin="0" aria-valuemax="100" style="width:10%">
    <span class="sr-only">10% complete</span>
  </div>
</div>
<br>
<br>
<div class="panel panel-default">
  <div class="panel-heading">Step 1: Verify Server</div>
  <div class="panel-body">In order for Glifcos to work, this webserver needs to be able to collaborate
  with it's target server. If you have setup the plugin correctly, simply restart your server. This page
  will automatically show your server data once we've recieved it. <br><br>
  
  <?php
  if (!is_file($_COOKIE["cl"]."/grudge.json")){
      echo '<div class="panel panel-danger">
              <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> Server Not Found</div>
              <div class="panel-body">Please continue to check your server, and make sure that your plugin is setup
              correctly..
              <br>
              <br>
              <div class="alert alert-warning">
                  Please refresh the page to check your server status again.
              </div>
              </div>
            </div>
            <a href="index.php" class="btn btn-primary disabled btn-block" role="button">Next Step</a>
            ';
  }
  else{
      $data = json_decode(file_get_contents($_COOKIE["cl"]."/grudge.json"), true);
      echo '<script>document.cookie="setup=2;";</script>';
      echo '
      <div class="panel panel-success">
              <div class="panel-heading"><i class="fa fa-check"></i> Linked Server!</div>
              <div class="panel-body">We have recieved data from your server! Verify that 
              <kbd>'.$data["ip"].':'.$data["port"].'</kbd> is your server address.
              </div>
            </div>
      <a href="index.php" class="btn btn-primary btn-block" role="button">Next Step</a>
      ';
  }
  ?>
  </div>
</div>
<!-- </div> -->