<?php

class AppLink
{
	
    private  $db_user = "";
    private  $db_name = "";
    private  $db_host = "";
    private  $db_pass = "";  
    
    protected $appLink = "http://www.paretti.pl/wyszukiwarka-ofert-pracy/ad/";    
    protected $con;
       
    public function  __construct()
    {
        $utf8name = "SET NAMES utf8";                   										    // ustawienie kodowania
        $utf8char = "SET CHARACTER_SET utf8_unicode_ci";
        
        $this->con = @new mysqli($this->db_host,$this->db_name,$this->db_pass,$this->db_name);       
        if ($this->con->connect_errno!=0)
        {
           echo $this->con->connect_errno; 
        }
        
        $result = $this->con->query($utf8name);
        $result = $this->con->query($utf8char);
        
        
          
    }
        
    public function sql_query($name)
    {
      $query = "SELECT id, cat_id, alias FROM `db_djcf_items` WHERE name = '$name'";      
      $result = $this->con->query($query);
      $result = $result->fetch_assoc();
      return $result;       
        
    }
    
    public function CatAliasQuery($cat_id)
    {
        $query = "SELECT alias FROM `db_djcf_categories` WHERE id = '$cat_id'";
        $result = $this->con->query($query);
        $result = $result->fetch_assoc();
        return $result;
     
    }   
    
    public function AppLinkGenerator($result, $category)
    
    {
        $AppLink=$this->appLink;
        $AppLink.=$category.','.$result['cat_id'].'/'.$result['alias'].','.$result['id'];
        return $AppLink;
    }
}






