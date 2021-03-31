
<?php
    class Charge{

        // Connection
        private $conn;

        // Table
        private $db_table_charge = "charge";

        // Columns
        public $id;
        public $int_id;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getCharge(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_charge} WHERE id = ? && int_id = ?  ";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->id);
            $stmt->bindParam(2, $this->int_id);
            $stmt->execute();
            return $stmt;
        }

    }

?>