<?php namespace Premkamon\PHPServer;

class Response 
{
	
	protected $body = '';
	protected $headers = [];
	private $client;
	protected $status;
	protected $textStatus = array(200=>"OK",404 => 'Not Found');
	
	public function __construct( $client,$status=200)
	{
		$this->client = $client;
		$this->status = $status;

		// set inital headers
		// $this->header( 'Cache-Control', 'no-store, no-cache, must-revalidate' );
		// $this->header( 'Connection', 'keep-alive');
		// $this->header( 'Pragma', 'no-cache'  );
		// $this->header( 'Transfer-Encoding', 'gzip'  );
		$this->header( 'Date', gmdate( 'D, d M Y H:i:s T' ) );
		// $this->header( 'Expires', gmdate( 'D, d M Y H:i:s T' , mktime(0, 0, 0, 1, 1, 1998)) );
		$this->header( 'Server', 'Premkamon (0.1) PHP Server' );
	}

	public function send($body){
		$this->header( 'Content-Type', 'text/html; charset=UTF-8' );
		$this->body = $body;
		$response = $this->buildHeaderString().$this->body();
		$this->writeData($response);
	}

	public function sendFile($filepath){
		$this->header( 'Content-Type', 'text/html; charset=UTF-8' );
		$body = file_get_contents($filepath);
		$response = $this->buildHeaderString().$body;
		$this->writeData($response);
	}

	public function sendJSON($body){
		$this->header( 'Content-Type', ' application/json; charset=UTF-8' );
		$this->body = $body;
		$response = $this->buildHeaderString().$this->body();
		$this->writeData($response);
	}

	public function download($body,$filename,$content_type){
		$this->header('Content-Type',$content_type);
		$this->header('Content-Disposition','attachment; filename='.$filename);
		$this->header('Pragma','no-cache');

		$this->body = $body;
		$response = $this->buildHeaderString().$this->body();
		$this->writeData($response);
	}

	private function writeData($response){
		echo "\npreparing response\n";
		socket_write( $this->client, $response, strlen( $response ) );
	}
	
	public function body()
	{
		return $this->body;
	}

	public function header( $key, $value )
	{
		$this->headers[ucfirst($key)] = $value;
	}
	
	public function buildHeaderString()
	{
		$lines = [];
		
		// response status 
		$lines[] = "HTTP/1.1 ".$this->status." ".$this->textStatus[$this->status];
			
		// add the headers
		foreach( $this->headers as $key => $value )
		{
			$lines[] = $key.": ".$value;
		}
		
		return implode( " \r\n", $lines )."\r\n\r\n";
	}

}