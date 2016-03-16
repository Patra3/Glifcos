<?php

/*
array (size=1)
  'fileToUpload' => 
    array (size=5)
      'name' => string 'Screenshot 2016-03-11 at 10.36.25 AM.png' (length=40)
      'type' => string 'image/png' (length=9)
      'tmp_name' => string '/tmp/phpZhePZk' (length=14)
      'error' => int 0
      'size' => int 66886
*/

if (!is_file("images/".$_FILES["fileToUpload"]["name"])){
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check != false){
        $h = fopen("images/".$_FILES["fileToUpload"]["name"], "w+");
        fwrite($h, file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
        fclose($h);
        $d = json_decode(file_get_contents($_COOKIE["cl"]."/users/".json_decode(base64_decode($_COOKIE["Authchain"]), true)["user"].".json"), true);
        $d["profile"] = "images/".$_FILES["fileToUpload"]["name"];
        unlink($_COOKIE["cl"]."/users/".json_decode(base64_decode($_COOKIE["Authchain"]), true)["user"].".json");
        $ds = fopen($_COOKIE["cl"]."/users/".json_decode(base64_decode($_COOKIE["Authchain"]), true)["user"].".json", "w+");
        fwrite($ds, json_encode($d));
        fclose($ds);
        echo '
        <script>
        window.location = "usermain.php?_reason=aW52YWxpZGltYWdl";
        </script>
        ';
    }
    else{
        echo "Invalid Image, please press browser back button and try again!";
    }
}
