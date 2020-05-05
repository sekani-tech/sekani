<?php
    class Dbconnect {
        private $host = "localhost";
        private $dbname = 'sekanisy_admin';
        private $user = 'sekanisy';
        private $pass = '4r6WY#JP+rnl67';
   

    public function connect(){
        try{
            $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbname, $this->user,
            $this->pass);
            $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch( PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    }
}
?>