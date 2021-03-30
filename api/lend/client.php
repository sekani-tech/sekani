
<?php
    class Client{

        // Connection
        private $conn;

        // Table
        private $db_table_client = "client";
        private $db_table_branch = "branch";

        // Columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $created;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getClient(){
            $sqlQuery = "SELECT * FROM  {$this->db_table_client}  JOIN  {$this->db_table_branch}  ON client.branch_id = branch.id WHERE status = 'Approved' ORDER BY firstname ASC";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }


        // READ single
        public function getSingleClient(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_client} WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt;
        }    

    }

?>