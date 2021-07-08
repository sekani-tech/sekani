<?php
// making a good move
include("../../../functions/connect.php");
// porty
session_start();
$int_id = $_SESSION["int_id"];
$branch_id = $_SESSION["branch_id"];
$staff_id = $_SESSION["staff_id"];
$network = $_POST["net"];
$phone = $_POST["phone"];
$amount = $_POST["amt"];
// MAD
$digits = 9;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// end the code
$username = $_SESSION["username"];
$pass = $_POST["pin"];
// end
if ($pass != "") {
    $query_pass = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    $x = mysqli_fetch_array($query_pass);
    $harsh_code = $x["pin"];
    if (password_verify($pass, $harsh_code) || $harsh_code == $pass) {
        if ($network != "" && $phone != "" && $amount != "" && $int_id != "" && $branch_id != "") {
            // finnin
            $sql_fund = mysqli_query($connection, "SELECT * FROM sekani_wallet WHERE int_id = '$int_id'");
                $qw = mysqli_fetch_array($sql_fund);
                $balance = $qw["bills_balance"];
                $total_with = $qw["total_withdrawal"];
                $total_int_profit = $qw["int_profit"];
                $total_sekani_charge = $qw["sekani_charge"];
                $total_merchant_charge = $qw["merchant_charge"];
                // test
                if ($balance >= $amount) {
                    // STAT API
                    $curl = curl_init();
        
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://shagopayments.com/api/live/b2b",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS =>"{\r\n\"serviceCode\" : \"QAB\",\r\n\"phone\" : \"$phone\",\r\n\"amount\": \"$amount\",\r\n\"vend_type\" : \"VTU \",\r\n\"network\": \"$network\",\r\n\"request_id\": \"$randms\"\r\n}",
                      CURLOPT_HTTPHEADER => array(
                        "hashKey: ddceb2126614e2b4aec6d0d247e17f746de538fef19311cc4c3471feada85d30",
                        "Content-Type: application/json"
                      ),
                    ));
                    
                    $response = curl_exec($curl);      
        $err = curl_close($curl);
        if ($err) {
            //    echo "cURL Error #:" . $err;
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "CONNECTION ERROR",
                    text: "TIMED OUT",
                    showConfirmButton: false,
                    timer: 3000
                })
                document.getElementById("cbvn").setAttribute("hidden", "");
                document.getElementById("wbvn").removeAttribute("hidden");
                $(":input[type=submit]").prop("disabled", true);
            });
            </script>
            ';
            echo "NO INTERNET CONNECTION";
            } else {
                // echo $response;
                // make 
        $obj = json_decode($response, TRUE);
        $status = $obj['status'];
        $msg = $obj['message'];
        // make a move
        if ($status == "200" && $status != "") {
            // alright
            $cal_bal = $balance - $amount;
            $cal_with = $total_with + $amount;
            $cal_sek = $total_sekani_charge + 0;
            $cal_mch = $total_merchant_charge + $amount;
            $cal_int_prof = $total_int_profit + 0;
            $digits = 9;
            $date = date("Y-m-d");
            $date2 = date('Y-m-d H:i:s');
            $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
            $trans = "SKWAL".$randms."AIRTIME".$int_id;
            // GD
            $update_transaction = mysqli_query($connection, "UPDATE sekani_wallet SET bills_balance = '$cal_bal', total_withdrawal = '$cal_with',
            int_profit = '$cal_int_prof', sekani_charge = '$cal_sek', merchant_charge = '$cal_mch' WHERE int_id = '$int_id' AND branch_id = '$branch_id'");
            if ($update_transaction) {
                // WE ARE DONE
                $insert_transaction = mysqli_query($connection, "INSERT INTO `sekani_wallet_transaction` (`int_id`, `branch_id`, `transaction_id`, `description`, `transaction_type`, `teller_id`, `is_reversed`, `transaction_date`, `amount`, `wallet_balance_derived`, `overdraft_amount_derived`, `balance_end_date_derived`, 
                `balance_number_of_days_derived`, `cumulative_balance_derived`, `created_date`, `manually_adjusted_or_reversed`, `credit`, `debit`,
                `int_profit`, `sekani_charge`, `merchant_charge`)
                 VALUES ('{$int_id}', '{$branch_id}', '{$trans}', 'Airtime Recharge $network - $phone', 'bill_airtime', NULL, '0', '{$date}', '{$amount}', '{$cal_bal}', '{$cal_bal}', {$date}, 
                 NULL, NULL, '{$date2}', '0', '0.00', '{$amount}', '{$cal_int_prof}', '{$cal_sek}', '{$cal_mch}')");
                 if ($insert_transaction) {
                    //  Check for Teller
                    $damn = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$int_id' && teller_id = '$staff_id'");
                    if (mysqli_num_rows($damn) > 0) {
                      $x = mysqli_fetch_array($damn);
                      $int_acct_bal = $x['account_balance_derived'];
                      $tbdx = $x['total_deposits_derived'] + $amount;
                      $new_int_bal = $amount + $int_acct_bal;

                      //  Once you are done Update Institution Account Balance
                       $iupq2 = mysqli_query($connection,"UPDATE institution_account SET account_balance_derived = '$new_int_bal', total_deposits_derived = '$tbdx' WHERE int_id = '$int_id' && teller_id = '$staff_id'");
                       // End Institution Account Balance
                    } else {
                      echo "No Account Found";
                    }
                    
                    //  go withdra
                    echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "success",
                    title: "'.$msg.'",
                    text: "AIRTIME SUCCESSFUL!",
                    showConfirmButton: false,
                    timer: 3000
                });
            });
            </script>
            ';
            $URL="airtime.php";
            echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                 } else {
                    //  NOTHING AT ALL
                    echo "ERROR IN TRANSACTION";
                 }
            } else {
                // NOTHING AT ALL
                echo "ERROR IN WALLET";
            }
        } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error Message - '.$msg.'",
                    text: "AIRTIME ERROR",
                    showConfirmButton: false,
                    timer: 5000
                });
            });
            </script>
            ';
        }
            }
                } else {
                    echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "INSUFFICIENT FUND",
                            text: "REFILL YOUR WALLET",
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
                    </script>
                    ';
                }
        }
    } else {
        echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "WRONG PIN",
                            text: "Please verify your pin",
                            showConfirmButton: false,
                            timer: 3000
                        });
            });
         </script>
        ';
    }
} else {
    echo '<script type="text/javascript">
                    $(document).ready(function(){
                        swal({
                            type: "error",
                            title: "PLEASE ENTER PIN",
                            text: "please enter your transaction pin",
                            showConfirmButton: false,
                            timer: 3000
                        });
            });
         </script>
        ';
}
?>