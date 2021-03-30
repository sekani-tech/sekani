
<?php
    class Staff{

        // Connection
        private $conn;

        // Table
        private $db_table_staff = "staff";

        // Columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $created;

        public $employee_status;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getStaff(){
            $sqlQuery = "SELECT * FROM {$this->db_table_staff} WHERE int_id = ? & employee_status = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->int_id);
            $stmt->bindParam(2 , $this->employee_status);
            $stmt->execute();
            return $stmt;
        }


        // READ single
        public function getSingleStaff(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_staff} WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->id);
            $stmt->execute();
            return $stmt;
        }    

    }

?>