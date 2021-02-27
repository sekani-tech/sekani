<?php
class Sekani{
  
    // database connection and table name
    private $conn;
    private $table_name = "account";
  
    // object properties
    public $id;
    public $int_id;
    public $total_deposit;
    public $total_withdrawal;
    public $running_balance;
    public $client_id;
    public $account_no;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create Airtime API
function airtime(){

    $select_query = "SELECT * FROM " . $this->table_name . " WHERE account_no =:account_no AND client_id =:client_id";
    // prepare query
    $stmt = $this->conn->prepare($select_query);
  
    // sanitize
    // $this->api_key=htmlspecialchars(strip_tags($this->api_key));
  
    // bind values
    $stmt->bindParam(":client_id", $this->client_id);
    $stmt->bindParam(":account_no", $this->account_no);
  
    // execute query
    $stmt->execute();
    
    $row = $stmt->fetch();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $id = $row["id"];
        $int_id = $row["int_id"];
        $branch_id = $row["branch_id"];
        $running_balance = $row["account_balance_derived"];
        $total_withdrawal = $row["total_withdrawals_derived"];
        $product_id = $row["product_id"];
    if ($running_balance >= $this->amount) {
        // get all the vaule to Shago
        $phone = $this->phone;
        $amount = $this->amount;
        $network = $this->network;
        $generate = $this->request_id;
        $account_no = $this->account_no;
        $client_id = $this->client_id;
        // start integration
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
        //   CURLOPT_URL => "http://34.68.51.255/shago/public/api/test/b2b",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"QAB\",\r\n\"phone\" : \"$phone\",\r\n\"amount\": \"$amount\",\r\n\"vend_type\" : \"VTU \",\r\n\"network\": \"$network\",\r\n\"request_id\": \"$generate\"\r\n}",
          CURLOPT_HTTPHEADER => array(
            "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
            "Content-Type: application/json"
            // "email: test@shagopayments.com",
            // "password: test123"
          ),
        ));
        // return true;
        $response = curl_exec($curl);      
        $err = curl_close($curl);
        if ($err) {
            echo json_encode(array("message" => "Network Error", "status" => "failed"));
        } else {
            $obj = json_decode($response, TRUE);
            $status = $obj['status'];
            $msg = $obj['message'];
            // status
            if ($status == "200" && $status != "") {
                $cal_bal = $running_balance - $amount;
                $cal_with = $total_withdrawal + $amount;
                $digits = 9;
                $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                $trans = "CLI".$randms."AIRTIME".$int_id;
                $date = date("Y-m-d");
                $date2 = date('Y-m-d H:i:s');

                // RUN UPDATE QUERY
                $update_query = "UPDATE
                " . $this->table_name . "
            SET
            account_balance_derived = :cal_bal,
            total_withdrawals_derived = :cal_with
            WHERE
                id = :id";

                // prepare query statement
    $stmtu = $this->conn->prepare($update_query);
    $stmtu->bindParam(':cal_bal', $cal_bal);
    $stmtu->bindParam(':cal_with', $cal_with);
    $stmtu->bindParam(':id', $id);

    if($stmtu->execute()){
        include("../../functions/connect.php");
        $query_table = mysqli_query($connection, "INSERT INTO `account_transaction` (`int_id`, `branch_id`, `product_id`, 
        `account_id`, `account_no`, `client_id`,
        `teller_id`, `transaction_id`, `description`,
        `transaction_type`, `is_reversed`, `transaction_date`,
        `amount`, `overdraft_amount_derived`, `balance_end_date_derived`,
        `balance_number_of_days_derived`, `running_balance_derived`, `cumulative_balance_derived`, 
        `created_date`, `appuser_id`, `manually_adjusted_or_reversed`, 
        `debit`, `credit`) 
        VALUES ('{$int_id}', '{$branch_id}', '{$product_id}', 
                '{$id}', '{$account_no}', '{$client_id}', 
                NULL, '{$trans}', 'bill_airtime', 
                'Debit', '0', '{$date2}', 
                '{$amount}', '{$amount}', NULL,
                NULL, '{$cal_bal}', NULL, 
                '{$date}', NULL, '0', 
                '{$amount}', '0.00')");

    // MAKE FINAL ECHO
    if($query_table){
        // Institution Account
        $query_int_walllet = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
        if (mysqli_num_rows($query_int_walllet) > 0) {
            $row = mysqli_fetch_array($query_int_walllet);
            $id = $row["id"];
            $branch_id = $row["branch_id"];
            $running_balance = $row["bills_balance"];
            $total_deposit = $row["total_deposit"];
            $total_withdrawal = $row["total_withdrawal"];
            $total_int_profit = $row["int_profit"];
            $total_merchant_charge = $row["merchant_charge"];
            $total_sekani_charge = $row["sekani_charge"];
            
            // Balance -- goes here
            $cal_bal = $running_balance - $amount;
            $cal_with = $total_withdrawal + $amount;
            $cal_sek = $total_sekani_charge + 0;
            $cal_mch = $total_merchant_charge + $amount;
            $cal_int_prof = $total_int_profit + 0;
            // $digits = 9;
            // $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            // $trans = "SKWAL".$randms."AIRTIME".$int_id;
            $date = date("Y-m-d");
            $date2 = date('Y-m-d H:i:s');

            // RUN UPDATE QUERY
            $update_queryx = "UPDATE
                sekani_wallet
            SET
            running_balance = :cal_bal,
            total_withdrawal = :cal_with,
            int_profit = :cal_int_prof,
            sekani_charge = :cal_sek,
            merchant_charge = :cal_mch
            WHERE
                id = :id";

            // prepare query statement
            $stmtu = $this->conn->prepare($update_queryx);
            $stmtu->bindParam(':cal_bal', $cal_bal);
            $stmtu->bindParam(':cal_with', $cal_with);
            $stmtu->bindParam(':cal_int_prof', $cal_int_prof);
            $stmtu->bindParam(':cal_sek', $cal_sek);
            $stmtu->bindParam(':cal_mch', $cal_mch);
            $stmtu->bindParam(':id', $id);

            if ($stmtu->execute()) {
                    $query_tablex = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                    `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                    `int_profit`, `sekani_charge`, `merchant_charge`)
                    VALUES ('{$int_id}', '{$branch_id}', '{$trans}',
                    '{$generate}', 'bill_airtime', 
                    NULL, '0', '{$date}', '{$amount}', '{$cal_bal}',
                    '{$cal_bal}', {$date}, 
                    NULL, NULL, '{$date2}', '0', '0.00', '{$amount}', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");

                    if ($query_tablex) {
                        echo json_encode(array("message" => "Airtime Transaction Successful", "transaction_id" => "$trans", "status" => "success"));
                        return true;
                    } else {
                        echo json_encode(array("message" => "Error at Inserting Wallet Transaction, Please Contact Sekani", "status" => "failed"));
                    }
                
            } else {
                echo json_encode(array("message" => "Error at Updating Wallet, Please Contact Sekani", "status" => "failed"));
            }
        }
        // End Insitution Account
        
    } else {
        echo json_encode(array("message" => "Error at Inserting Wallet Transaction, Please Contact Sekani", "status" => "failed"));
        return false;
    }
    } else {
        echo json_encode(array("message" => "Error at Updating Wallet, Please Contact Sekani", "status" => "failed"));
        return false;
    }
            } else {
                echo json_encode(array("message" => "Unable to Recharge Airtime. Please Check Request id for duplicate", "status" => "failed"));
                return false;
            }
        }
    } else {
        // Balance not Up to
        echo json_encode(array("message" => "Insufficient Fund, Please Fund your Account!", "status" => "failed"));
        return false;
    }
} else {
    echo json_encode(array("message" => "Client Account Institution Found", "status" => "failed"));
    return false;
}
    
}

// Airtime
}