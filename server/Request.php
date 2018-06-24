<?php namespace Premkamon\PHPServer;


class Request 
{
	
	protected $method = null;
	protected $uri = null;
	private $client;
	protected $body = array();
	protected $parameters = [];
	
	public function __construct( $method, $uri ,$body) 
	{
		$this->method = strtoupper( $method );
		$this->uri = strtolower( $uri );
		$this->body = $body;

		@list( $this->uri, $params ) = explode( '?', $uri );

		// parse the parmeters
		parse_str( $params, $this->parameters );
	}

	public static function parse( $data )
	{

		
		$lines = explode( "\n", $data );
	
		// // method and uri
		$x = array_shift( $lines );

		// echo "\n\n\start\n";
		// echo $data."\n\n";
		// print_r($x);
		// echo "\nend\n";
		list( $method, $uri ) = explode( ' ', $x );
		//echo " ".$method."  ".$uri." ";
		$body = array();
		for($i=count($lines)-1;$i>0;$i--){
			if(trim(strval($lines[$i]))==""){
				break;
			}
			list($key,$value) = explode("=",$lines[$i]);

			$body[$key] = $value;
		}
	

		return new static( $method, $uri,$body);
	}

	
	public function post($index=""){
		if($index==""){
			foreach($this->body as $key=>$p){
				$this->body[$key] = urldecode($p);
			}
			return $this->body;
		}else{
			if(isset($this->body[$index])){
				return urldecode($this->body[$index]);
			}else{
				return false;
			}
			
		}
	}

	public function get($index=""){
		if($index==""){
			foreach($this->parameters as $key=>$p){
				$this->parameters[$key] = urldecode($p);
			}
			return $this->parameters;
		}else{
			if(isset($this->parameters[$index])){
				return urldecode($this->parameters[$index]);
			}else{
				return false;
			}
			
		}
	}
	
	public function method()
	{
		return $this->method;
	}
	
	public function uri()
	{
		return $this->uri;
	}

	public function param( $key, $default = null )
	{
		if ( !isset( $this->parameters[$key] ) )
		{
			return $default;
		}
		
		return $this->parameters[$key];
	}
	
}