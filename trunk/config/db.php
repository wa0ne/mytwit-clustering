<?php

class db{

	private $server="localhost";
	private $user="root";
	private $pass="";
	private $db="mytwit";
	private $conn;
		
	public function __construct(){
		
		$this->conn=mysql_connect($this->server,$this->user,$this->pass);
		mysql_select_db($this->db,$this->conn);
	
	}
	
}







