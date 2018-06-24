<?php namespace Premkamon\MyDatabase;
use \PDO;

class Database 
{
	
	protected $conn;
	protected $username;
	protected $password;
	protected $dbname;
	public function __construct( $servername,$username,$password,$dbname)
	{
		$this->servername = $servername;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->connect();
	}

	public function connect(){
		try {
		    $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
		    // set the PDO error mode to exception
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    	echo "Connected successfully"; 
		    }
		catch(PDOException $e)
	    {
	    	echo "Connection failed: " . $e->getMessage();
	    }
	    return $this->conn;
	}

	public function query($sql){
		return $this->conn->query($sql);
	}
}