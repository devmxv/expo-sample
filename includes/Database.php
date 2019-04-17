<?php
/*------------
/* Database.php Clase para realizar la conexión a BD
*/

class Database {

	private $host = "localhost";
	private $db_name = "expotyt";
	private $username = "root";
	private $password = "";

	public $conn;


	//---para abrir conexión de BD
	public function connect() {
		$this->conn = null;

		try{
			$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->username,$this->password);
		} catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->conn;
	}
}



?>