<?php
	
class db{
	private $dbhost = 'localhost';
	private $dbuser = 'root';
	private $dbpass = '';
	private $dbname = 'pharmacies';
	
	public function connect(){
		$mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
		$dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbConnection->exec("SET NAMES 'utf8'");
		$dbConnection->exec("SET CHARACTER SET 'utf8'");
		return $dbConnection;
	}
}