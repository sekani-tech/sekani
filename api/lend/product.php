<?php
    class Product{

        // Connection
        private $conn;

        // Table
        private $db_table_product = "product";
        private $db_table_savings_product = "savings_product";

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
        public function getProduct(){
            $sqlQuery = "SELECT * FROM {$this->db_table_product} WHERE int_id = ? ORDER BY name ASC";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->int_id);
            $stmt->execute();
            return $stmt;
        }


        // GET ALL
        public function getSavingProduct(){
            $sqlQuery = "SELECT * FROM {$this->db_table_savings_product} WHERE id = ? AND int_id = ? ";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->id);
            $stmt->bindParam(2 , $this->int_id);
            $stmt->execute();
            return $stmt;
        }


        // READ single
        public function getSingleProduct(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_product} WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->id);
            $stmt->execute();
            return $stmt;
        }    
        
    }

?>