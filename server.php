<?php

require 'vendor/autoload.php';
use Premkamon\PHPServer\Server;  
use Premkamon\PHPServer\App;  
use Premkamon\MyDatabase\Database;  



$server = new Server();
$app = new App($server);



//this route request list of product
$app->get("/",function($req,$res){
	$req->get("");
	return $res->sendFile("index.html");
});


//this route get all product
$app->get("/get-all-products",function($req,$res){
	$db = new Database("localhost","root","","assign");
	$products = $db->query("select * from products")->fetchAll(PDO::FETCH_CLASS, 'Premkamon\DataModel\Products');
	$json = json_encode($products);
	return $res->sendJSON($json);
});



$app->get("/import-products",function($req,$res){
	return $res->send("hello world post");
});



$app->post("/import-products",function($req,$res){
	$db = new Database("localhost","root","","assign");
	//$conn = $db->connect();

	$jsonData = $req->post("jsonData");
	$json = json_decode($jsonData );
	
	foreach ($json as $j)
	{
		if(isset($j->name) && isset($j->description) && isset($j->price) && isset($j->stock)  ){
			$db->query("insert into products (Name,Description,Price,Stock) values ('$j->name','$j->description','$j->price','$j->stock')");
		}
		
	}

	return $res->send($jsonData);
});


$app->get("/export-products",function($req,$res){
	$db = new Database("localhost","root","","assign");
	//$conn = $db->connect();
	
	$products = $db->query("select * from products")->fetchAll(PDO::FETCH_CLASS, 'Premkamon\DataModel\Products');
	$csv = "name,description,price,stock \n";//Column headers
	foreach ($products as $p)
	{
	    $csv.= $p->Name.','.$p->Description.','.$p->Price.','.$p->Stock."\n"; //Append data to csv
	}

	return $res->download($csv,'products.csv','application/csv');
});



$server->listen('127.0.0.1', '8080', function(){
	echo "server started";
});

