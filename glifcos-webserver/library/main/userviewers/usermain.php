<html>
    <head>
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
        <!-- W3 CSS -->
        <link rel="stylesheet" href="w3.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- COMPAT -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <!-- CUSTOM RALEWAY FONT -->
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway" />
        <title>Glifcos - View Users</title>
    </head>
    <body style="font-family: Raleway, Serif;">
        <?php
            if ($_GET["_reason"] === "aW52YWxpZGltYWdl"){
                echo '<div class="w3-container w3-green">
                <h2>Profile Picture updated!</h2>
                <span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">x</span>
                </div>
                ';
            }
            ?>
        <div class="w3-container">
            <br>
            <div class="w3-card-4" style="width:100%">
                <header class="w3-container w3-yellow">
                  <h1 style="font-family: Raleway, Serif;">User Manager</h1>
                </header>
                <div class="w3-container">
                    <br>
                    <a href="<?php echo $_COOKIE["origin-point"]; ?>" 
                    class="w3-btn w3-green">Back to Glifcos</a>
                    <br>
                    <br>
                    <!-- BODY -->
                    <?php
                    $u = scandir($_COOKIE["cl"]."/users");
                    //remove weird .. things :P
                    unset($u[array_search(".", $u)]);
                    unset($u[array_search("..", $u)]);
                    chdir($_COOKIE["cl"]."/users");
                    foreach($u as $data){
                        $data = json_decode(file_get_contents($data), true);
                        if (!isset($data["profile"])){
                            $profile = "images/default_no_profile.jpg";
                        }
                        else{
                            $profile = $data["profile"];
                        }
                        if ($data["user"] === json_decode(base64_decode($_COOKIE["Authchain"]), true)["user"]){
                            $options = '
                            <a onclick="document.getElementById(\'profile2\').style.display=\'block\'">Change Picture</a>
                            <a href="#">Change Password</a>
                            <a href="#">Change Username</a>
                            <a disabled class="w3-green">This is you!</a>
                            ';
                        }
                        else{
                            $options = '
                            <a onclick="document.getElementById(\'deletemodal\').style.display=\'block\'" class="w3-red">Delete User</a>
                            ';
                        }
                        echo '
                        <div class="w3-third">
                          <div class="w3-card">
                          <center>
                            <img src="'.$profile.'" style="width:20%;">
                            <div class="w3-container">
                              <h4 style="font-family: Raleway, Serif;">'.$data["user"].'</h4>
                              <div class="w3-dropdown-hover">
                                  <button class="w3-btn w3-green">Actions</button>
                                  <div class="w3-dropdown-content w3-border">
                                  '.$options.'
                                  </div>
                                </div>
                                <br>
                                <br>
                            </div>
                          </center>
                          </div>
                        </div>
                        ';
                    }
                    ?>
                </div>
                <br>
            </div>
        </div>
    </body>
    <!-- CHANGE PROFILE PICTURE MODAL-->
    <div id="profile2" class="w3-modal">
      <div class="w3-modal-content w3-animate-top">
        <header class="w3-container w3-yellow">
            <span onclick="document.getElementById('profile2').style.display='none'" 
          class="w3-closebtn">&times;</span>
            <h4>Change Profile Picture</h4>
        </header>
        <div class="w3-container">
          <br>
          <form action="upload.php" method="post" enctype="multipart/form-data"
          class="w3-container">
                <input type="file" name="fileToUpload" id="fileToUpload" 
                class="w3-input">
                <br>
                <input type="submit" value="Upload Image" name="submit" 
                class="w3-btn w3-yellow">
            </form>
        </div>
      </div>
    </div>
    <div id="deletemodal" class="w3-modal">
        <div class="w3-modal-content w3-animate-top">
            <header class="w3-container w3-red">
                <h4>Delete User?</h4>
            </header>
        </div>
    </div>
</html>