<?php
class Database{
  
    // specify your own database credentials
    // pushing live
    private $host = "localhost";
    private $db_name = "sekanisy_admin";
    private $username = "sekanisy";
    private $password = "4r6WY#JP+rnl67";
    public $conn;
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>