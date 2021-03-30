
<?php
    class Account{

        // Connection
        private $conn;

        // Table
        private $db_table_account = "account";

        // Columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $created;

        public $int_id;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ACCOUNT
        public function getAccount(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_account} WHERE id = ? ";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->id);
            $stmt->execute();
            return $stmt;
        }

    }

?>