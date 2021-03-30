

<?php
    class Kyc{

        // Connection
        private $conn;

        // Table
        private $db_table_kyc = "kyc";

        // Columns
        public $client_id;
        public $int_id;
        public $marital_status;
        public $no_of_dependent;
        public $level_of_ed;
        public $emp_stat;
        public $emp_bus_name;
        public $income;
        public $years_in_job;
        public $res_type;
        public $rent_per_year;
        public $year_in_res;
        public $other_bank;
        public $emp_category;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getKyc(){
            $sqlQuery = "SELECT *  FROM  {$this->db_table_kyc} WHERE client_id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1 , $this->client_id);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createKyc(){
            $sqlQuery = "INSERT INTO
                        {$this->db_table_kyc}
                    SET
                        int_id = :int_id, 
                        client_id = :client_id, 
                        marital_status = :marital_status, 
                        no_of_dependent = :no_of_dependent, 
                        level_of_ed = :level_of_ed,
                        emp_stat = :emp_stat,
                        emp_bus_name = :emp_bus_name,
                        income = :income,
                        years_in_job = :years_in_job,
                        res_type = :res_type,
                        rent_per_year = :rent_per_year,
                        year_in_res = :year_in_res,
                        other_bank = :other_bank,
                        emp_category = :emp_category";
        
            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->int_id=htmlspecialchars(strip_tags($this->int_id));
            $this->client_id=htmlspecialchars(strip_tags($this->client_id));
            $this->marital_status=htmlspecialchars(strip_tags($this->marital_status));
            $this->no_of_dependent=htmlspecialchars(strip_tags($this->no_of_dependent));
            $this->level_of_ed=htmlspecialchars(strip_tags($this->level_of_ed));
            $this->emp_stat=htmlspecialchars(strip_tags($this->emp_stat));
            $this->emp_bus_name=htmlspecialchars(strip_tags($this->emp_bus_name));
            $this->income=htmlspecialchars(strip_tags($this->income));
            $this->years_in_job=htmlspecialchars(strip_tags($this->years_in_job));
            $this->res_type=htmlspecialchars(strip_tags($this->res_type));
            $this->rent_per_year=htmlspecialchars(strip_tags($this->rent_per_year));
            $this->year_in_res=htmlspecialchars(strip_tags($this->year_in_res));
            $this->other_bank=htmlspecialchars(strip_tags($this->other_bank));
        
            // bind data
            $stmt->bindParam(":int_id", $this->int_id);
            $stmt->bindParam(":client_id", $this->client_id);
            $stmt->bindParam(":marital_status", $this->marital_status);
            $stmt->bindParam(":no_of_dependent", $this->no_of_dependent);
            $stmt->bindParam(":level_of_ed", $this->level_of_ed);
            $stmt->bindParam(":emp_stat", $this->emp_stat);
            $stmt->bindParam(":emp_bus_name", $this->emp_bus_name);
            $stmt->bindParam(":income", $this->income);
            $stmt->bindParam(":years_in_job", $this->years_in_job);
            $stmt->bindParam(":res_type", $this->res_type);
            $stmt->bindParam(":rent_per_year", $this->rent_per_year);
            $stmt->bindParam(":year_in_res", $this->year_in_res);
            $stmt->bindParam(":other_bank", $this->other_bank);
            $stmt->bindParam(":emp_category", $this->emp_category);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        } 

        // UPDATE
        public function updateKyc(){
            $sqlQuery = "UPDATE
                        {$this->db_table_kyc}
                    SET
                        int_id = :int_id, 
                        client_id = :client_id, 
                        marital_status = :marital_status, 
                        no_of_dependent = :no_of_dependent, 
                        level_of_ed = :level_of_ed,
                        emp_stat = :emp_stat,
                        emp_bus_name = :emp_bus_name,
                        income = :income,
                        years_in_job = :years_in_job,
                        res_type = :res_type,
                        rent_per_year = :rent_per_year,
                        year_in_res = :year_in_res,
                        other_bank = :other_bank,
                        emp_category = :emp_category
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->int_id=htmlspecialchars(strip_tags($this->int_id));
            $this->client_id=htmlspecialchars(strip_tags($this->client_id));
            $this->marital_status=htmlspecialchars(strip_tags($this->marital_status));
            $this->no_of_dependent=htmlspecialchars(strip_tags($this->no_of_dependent));
            $this->level_of_ed=htmlspecialchars(strip_tags($this->level_of_ed));
            $this->emp_stat=htmlspecialchars(strip_tags($this->emp_stat));
            $this->emp_bus_name=htmlspecialchars(strip_tags($this->emp_bus_name));
            $this->income=htmlspecialchars(strip_tags($this->income));
            $this->years_in_job=htmlspecialchars(strip_tags($this->years_in_job));
            $this->res_type=htmlspecialchars(strip_tags($this->res_type));
            $this->rent_per_year=htmlspecialchars(strip_tags($this->rent_per_year));
            $this->year_in_res=htmlspecialchars(strip_tags($this->year_in_res));
            $this->other_bank=htmlspecialchars(strip_tags($this->other_bank));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":int_id", $this->int_id);
            $stmt->bindParam(":client_id", $this->client_id);
            $stmt->bindParam(":marital_status", $this->marital_status);
            $stmt->bindParam(":no_of_dependent", $this->no_of_dependent);
            $stmt->bindParam(":level_of_ed", $this->level_of_ed);
            $stmt->bindParam(":emp_stat", $this->emp_stat);
            $stmt->bindParam(":emp_bus_name", $this->emp_bus_name);
            $stmt->bindParam(":income", $this->income);
            $stmt->bindParam(":years_in_job", $this->years_in_job);
            $stmt->bindParam(":res_type", $this->res_type);
            $stmt->bindParam(":rent_per_year", $this->rent_per_year);
            $stmt->bindParam(":year_in_res", $this->year_in_res);
            $stmt->bindParam(":other_bank", $this->other_bank);
            $stmt->bindParam(":emp_category", $this->emp_category);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

    }

?>