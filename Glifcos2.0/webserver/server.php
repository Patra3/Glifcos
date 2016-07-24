<?php

$request = $_POST["request"];

if ($request === null){
    return;
}
elseif ($request === "getGlifcosState"){
    // Call this POST request to get the Glifcos setup state.
    /*
    1 = Not setup,
    2 = Already setup
    */
    if (!is_file("database/config.txt")){
        echo 1;
    }
    else{
        echo 2;
    }
}