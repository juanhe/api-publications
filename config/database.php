<?php
class Database{
    
    //Credenciales
    private $host = "localhost";
    private $db_name = "u675098769_ingeniat";
    private $username = "u675098769_ingeniat";
    private $password = "1Ng3n14t";
    public $conn;
 
    //Conexion a DB
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>