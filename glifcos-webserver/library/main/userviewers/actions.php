<?php

/*
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
*/
if (isset($_GET["usernew_"])){
 if (empty($_GET["usernew_"])){
  die("Error. Username field empty. Please press the back button and try again.");
 }
 else{
  // Change username of current user.
  $keychain = json_decode(base64_decode($_COOKIE["Authchain"]), true);
  $data = json_decode(file_get_contents($_COOKIE["cl"]."/users/".$keychain["user"].".json"), true);
  $data["user"] = $_GET["usernew_"];
  unlink($_COOKIE["cl"]."/users/".$keychain["user"].".json");
  $h = fopen($_COOKIE["cl"]."/users/".$_GET["usernew_"].".json", "w+");
  fwrite($h, json_encode($data));
  fclose($h);
  echo '
   <script>
   window.location = "usermain.php?_reason=sub";
   </script>
   ';
 }
}
if (isset($_GET["pswdnew_"])){
 if (empty($_GET["pswdnew_"])){
  die("Error. Username field empty. Please press the back button and try again.");
 }
 else{
  // Change username of current user.
  $keychain = json_decode(base64_decode($_COOKIE["Authchain"]), true);
  $data = json_decode(file_get_contents($_COOKIE["cl"]."/users/".$keychain["user"].".json"), true);
  $data["password"] = password_hash($_GET["pswdnew_"], PASSWORD_DEFAULT);
  unlink($_COOKIE["cl"]."/users/".$keychain["user"].".json");
  $h = fopen($_COOKIE["cl"]."/users/".$keychain["user"].".json", "w+");
  fwrite($h, json_encode($data));
  fclose($h);
  echo '
   <script>
   window.location = "usermain.php?_reason=sub1";
   </script>
   ';
 }
}
if (isset($_GET["delete"])){
 if (empty($_GET["delete"])){
  // what? $_GET["delete"] is empty..
  die("Error. Delete field empty. Please press the back button and try again.");
 }
 else{
  if (!is_file($_COOKIE["cl"]."/users/".$_GET["delete"].".json")){
   // Deleting user file not found.
   die("Error. File not found. Please press the back button and try again.");
  }
  else{
   // Delete :D
   unlink($_COOKIE["cl"]."/users/".$_GET["delete"].".json");
   echo '
   <script>
   window.location = "usermain.php?_reason=ZGVsZXRlZGF1c2Vy";
   </script>
   ';
  }
 }
}