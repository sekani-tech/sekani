
<?php
    class Payment{

        // Connection
        private $conn;

        // Table
        private $db_table_payment_type = "payment_type";

        // Columns
        public $id;
        public $int_id;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getPaymentType(){
            $sqlQuery = "SELECT * FROM {$this->db_table_payment_type} WHERE int_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->int_id);
            $stmt->execute();
            return $stmt;
        }


        // READ single
        public function getSinglePayment(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_payment_type} WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->id);
            $stmt->execute();
            return $stmt;
        }    

    }

?>