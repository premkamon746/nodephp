<?php namespace Premkamon\PHPServer;

use Premkamon\PHPServer\Request; 
use Premkamon\PHPServer\Response; 
use Premkamon\PHPServer\Handle;  

class Server 
{
	protected $host = null;
	protected $port = null;
	protected $socket = null;
	public $test="hihi";

	public function __construct(  )
	{
		//$this->host = $host;
		//$this->port = (int) $port;
		//$this->createSocket();
		
		
		//$this->bind();
	}

	public function listen( $host,$port,$callback ){
		$this->host = $host;
		$this->port = (int) $port;

		//create socket
		$this->socket = socket_create( AF_INET, SOCK_STREAM, 0 );
		
		//bind socke
		if ( !socket_bind( $this->socket, $this->host, $this->port ) )
		{
			echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
		}

		call_user_func( $callback);

		while ( 1 ) 
		{
			echo "\n\n waiting connection\n";
			socket_listen( $this->socket );
				
			if ( !$client = socket_accept( $this->socket ) ) 
			{
				socket_close( $client ); continue;
			}

			$sock_read = socket_read( $client, 1024 );
			if(trim($sock_read ==""))break;
			$request =  Request::parse( $sock_read  );

			//replace query string 
			$pattern = '/\?.+/';
			$uri = preg_replace($pattern, "", $request->uri());


			//crate array index from method and uri
			$hd_idx = $uri.$request->method();
			//
			if(isset($this->handle[$hd_idx])){

				call_user_func( $this->handle[$hd_idx],$request,new Response($client));
			}else{
				//echo "request was not found";
				$res = new Response($client,404);
				$res->send("404 page not found");
			}

			socket_close( $client );
		}

	}
	

	private $handle = array();
	public function register($url,$method,$callback){
		
		$this->handle[$url.$method] = $callback;
	}
}