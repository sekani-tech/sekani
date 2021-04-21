<?php
    class Collateral{

        // Connection
        private $conn;

        // Table
        private $db_table_collateral = "collateral";

        // Columns
        public $date;
        public $type;
        public $value;
        public $description;

        public $int_id;
        public $client_id;
        public $id;
        public $status;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCollateral(){
            $sqlQuery = "SELECT * FROM {$this->db_table_collateral} WHERE int_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->int_id);
            $stmt->execute();
            return $stmt;
        }

        // GET ALL
        public function getCollateralClient(){
            $sqlQuery = "SELECT * FROM {$this->db_table_collateral} WHERE client_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->client_id);
            $stmt->execute();
            return $stmt;
        }


        // CREATE
        public function createCollateral(){
            $sqlQuery = "INSERT INTO
                        {$this->db_table_collateral}
                    SET
                        date = :date, 
                        type = :type, 
                        value = :value, 
                        description = :description, 
                        int_id = :int_id,
                        status = :status,
                        client_id = :client_id";

            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->date=htmlspecialchars(strip_tags($this->date));
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->value=htmlspecialchars(strip_tags($this->value));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->int_id=htmlspecialchars(strip_tags($this->int_id));
            $this->client_id=htmlspecialchars(strip_tags($this->client_id));
            $this->status=htmlspecialchars(strip_tags($this->status));
        
            // bind data
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":value", $this->value);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":int_id", $this->int_id);
            $stmt->bindParam(":client_id", $this->client_id);
            $stmt->bindParam(":status", $this->status);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

    }

?>