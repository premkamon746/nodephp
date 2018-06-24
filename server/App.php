<?php

namespace Premkamon\PHPServer;
//use Premkamon\PHPServer\Server;  
class App{

    private $server;
    public function __construct($server ){
        $this->server = $server;
    }
 

    public function get($mapURI,$callback){
        $this->server->register($mapURI,"GET",$callback);
    }


    public function post($mapURI,$callback){
        $this->server->register($mapURI,"POST",$callback);
    }

    public function put($mapURI,$callback){
        $this->server->register($mapURI,"PUT",$callback);
    }

    public function delete($mapURI,$callback){
        $this->server->register($mapURI,"DELETE",$callback);
    }


}