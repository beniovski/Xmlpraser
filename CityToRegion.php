<?php

class CityToRegion 
{
	private  $db_user = "";
	private  $db_name = "";
	private  $db_host = "";
	private  $db_pass = "";
	protected $con;
	
	private function dbConnection()
	{
		$utf8name = "SET NAMES utf8";                   										    // ustawienie kodowania
		$utf8char = "SET CHARACTER_SET utf8_polish_ci";
	
		$this->con = @new mysqli($this->db_host,$this->db_name,$this->db_pass,$this->db_name);
		if ($this->con->connect_errno!=0)
		{
			echo $this->con->connect_errno;
		}
	
		$result = $this->con->query($utf8name);
		$result = $this->con->query($utf8char);	
	
	}
	
	
	 function Region($city)
	{
	 	$this->dbConnection();	 		
		$query = "SELECT region  FROM `city` WHERE city = '$city'";
		$result = $this->con->query($query);
		$result = $result->fetch_assoc();
		$result = $result['region'];
		return $result;
		
	}
	
	
	
}
