<?php

namespace Glifcos\tasks;

use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;

class AsyncDataSender extends AsyncTask {
    
    public $data;
    public $webserver;
    
    public function __construct($json_data, $webserver){
        $this->data = $json_data;
        $this->webserver = $webserver;
    }
    public function onRun(){
        Utils::postURL($this->webserver, json_decode($this->data, true));
    }
}