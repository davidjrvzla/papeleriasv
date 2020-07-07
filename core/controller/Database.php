<?php
class Database {
	public static $db;
	public static $con;
	function Database(){
		$this->user="root";$this->pass="";$this->host="localhost";$this->ddbb="papeleriasv";
		//$this->user="b115ed655ac058";$this->pass="1cbfa91a";$this->host="us-cdbr-east-05.cleardb.net";$this->ddbb="heroku_18dab1401d4ee8b";
	}

	function connect(){
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		$con->query("set sql_mode=''");
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}
	
}
?>
