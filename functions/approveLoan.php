<?php
include("connect.php");
session_start();

$sessint_id = $_SESSION["int_id"];
$userid = $_SESSION["user_id"];
$tday = date('Y-m-d');
$client_id = $_POST["client_id"];
$goacctn = mysqli_query($connection, "SELECT account_no FROM client WHERE id = '$client_id' ");
if (count([$goacctn]) == 1) {
    $a = mysqli_fetch_array($goacctn);
    $acct_no = $a['account_no'];
}
$product_id = $_POST['product_id'];
$principal_amount = $_POST['principal_amount'];
$loan_term = $_POST['loan_term'];
$repay_every = $_POST['repay_every'];
$interest_rate = $_POST['interest_rate'];
$disbursement_date = $_POST['disbursement_date'];
$loan_officer = $_POST['loan_officer'];
$loan_purpose = $_POST['loan_purpose'];
$linked_savings_acct = $_POST['linked_savings_acct'];
$repay_start = $_POST['repay_start'];
// part for collatera
$col_id = $_POST['col_id'];
$col_name = $_POST['col_name'];
$col_description = $_POST['col_description'];
// gaurantors
$first_name = $_POST['gau_first_name'];
$last_name = $_POST['gau_last_name'];
$phone = $_POST['gau_phone'];
$phone2 = $_POST['gau_phone2'];
$home_address = $_POST['gau_home_address'];
$office_address = $_POST['gau_office_address'];
$position_held = $_POST['gau_position_held'];
$email = $_POST['gau_email'];
// date of submitted
// lc
$r = $interest_rate;
$prina = $principal_amount;
$gi = $r * $prina;
$pd = $gi + $prina;
// term frequency
$tff = $loan_term - 1;

$submitted_on = date("Y-m-d h:m:s");
$currency = "NGN";
$cd = 2;
$query = "INSERT INTO loan_disbursement_cache (int_id, account_no, client_id,
product_id, col_id, col_name, col_description,
loan_officer, loan_purpose, currency_code,
currency_digits, principal_amount_proposed, principal_amount,
loan_term, interest_rate, approved_principal, repayment_date,
term_frequency, repay_every, number_of_repayments, submittedon_date,
submittedon_userid, approvedon_date, approvedon_userid,
expected_disbursedon_date, expected_firstrepaymenton_date, disbursement_date,
disbursedon_userid, repay_principal_every, repay_interest_every) VALUES ('{$sessint_id}', '{$acct_no}', '{$client_id}',
'{$product_id}', '{$col_id}', '{$col_name}', '{$col_description}',
'{$loan_officer}', '{$loan_purpose}', '{$currency}', '{$cd}',
'{$principal_amount}', '{$pd}', '{$loan_term}', '{$interest_rate}',
'{$principal_amount}', '{$repay_start}', '{$tff}', '$repay_every',
'{$loan_term}', '{$submitted_on}', '{$userid}', '{$submitted_on}', '{$userid}',
'{$disbursement_date}', '{$repay_start}', '{$disbursement_date}',
'{$userid}', '{$loan_term}', '{$loan_term}')";
// stopped at principal amount
$digits = 6;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
// first test client loan status then test the running balance in the institution acct.
$verify = mysqli_query($connection, "SELECT * FROM institution_account WHERE int_id = '$sessint_id'");
    if (count([$verify]) == 1) {
        $x = mysqli_fetch_array($verify);
        $int_acct_bal = $x['account_balance_derived'];
        $calprinamt = $principal_amount;
        $acctprin = $int_acct_bal - $calprinamt;
        $branchhl = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id'");
                if (count([$branchhl]) == 1) {
                    $yxx = mysqli_fetch_array($branchhl);
                    $lsff = $yxx['loan_status'];
                }
        if ($acctprin >= 0 && $lsff == "Not Active") {
            $res = mysqli_query($connection, $query);
            if ($res) {
                $brancl = mysqli_query($connection, "SELECT * FROM client WHERE id = '$client_id'");
                if (count([$brancl]) == 1) {
                    $yx = mysqli_fetch_array($brancl);
                    $branch_id = $yx['branch_id'];
                    $lsf = $yx['loan_status'];
                    // quick loan test
                    $pkn = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$client_id'");
                    if (count([$pkn]) == 1) {
                        $gf = mysqli_fetch_array($pkn);
                        $abd = $gf['account_balance_derived'];
                    // update institution account balance derived
                    $upacctb = $acctprin;
                    $iupq = "UPDATE institution_account SET account_balance_derived = '$upacctb' WHERE int_id = '$sessint_id'";
                    $iupres = mysqli_query($connection, $iupq);
                    if($iupres) {
                    // insert into institution account transaction
                    $tess = 10;
                    $trans_id = str_pad(rand(0, pow(10, $tess)-1), $digits, '0', STR_PAD_LEFT);
                    $trans_type = "debit";
                    $trans_date = date("Y-m-d h:m:s");
                    $trans_amt = $calprinamt;
                    $irvs = 0;
                    $ova = 0;
                    $running_b = $upacctb;
                    $created_date = date("Y-m-d h:m:s");

                    $iat = "INSERT INTO institution_account_transaction (int_id, branch_id,
                    client_id, transaction_id, transaction_type, is_reversed,
                    transaction_date, amount, running_balance_derived, overdraft_amount_derived,
                    created_date) VALUES ('{$sessint_id}', '{$branch_id}',
                    '{$client_id}', '{$trans_id}', '{$trans_type}', '{$irvs}',
                    '{$trans_date}', '{$trans_amt}', '{$running_b}', '{$trans_amt}',
                    '{$created_date}')";
                    $res2 = mysqli_query($connection, $iat);
                    if ($res2) {
                    // update client loan status
                    $lsxx = "Active";
                    $clsu = "UPDATE client SET loan_status = '$lsxx' WHERE id = '$client_id'";
                    $clsures = mysqli_query($connection, $clsu);
                    if ($clsures) {
                        // update client account (savings or current)
                        $cabd = $abd + $principal_amount;
                        $ladd = date("Y-m-d h:m:s");
                        $oyacbu = "UPDATE account SET updatedon_date = '$tday', account_balance_derived = '$cabd',
                        last_activity_date = '$ladd' WHERE client_id = '$client_id'";
                        $gomrca = mysqli_query($connection, $oyacbu);
                        if ($gomrca) {
                            // insert into client account transaction
                            $colacct = mysqli_query($connection, "SELECT * FROM account where client_id = '$client_id'");
                            if (count([$colacct]) == 1) {
                                $mov = mysqli_fetch_array($colacct);
                                $a_product_id = $product_id;
                                $acctnt_no = $mov['account_no'];
                                $acctrunb = $mov['account_balance_derived'];
                                $hsj = 6;
                                $transac_id = str_pad(rand(0, pow(10, $hsj)-1), $digits, '0', STR_PAD_LEFT);
                                $transac_type = "credit";
                                $transac_date = date("Y-m-d h:m:s");
                                $transac_amt = $calprinamt;
                                $cova = 0;
                                $crunning_b = $acctrunb + $calprinamt;
                                $trans_created_date = date("Y-m-d h:m:s");

                                $colacctts = "INSERT INTO account_transaction (int_id,
                                branch_id, product_id, account_no, client_id,
                                transaction_id, transaction_type, is_reversed, transaction_date, amount,
                                running_balance_derived, created_date) VALUES ('{$sessint_id}',
                                '{$branch_id}', '{$product_id}', '{$acctnt_no}',
                                '{$client_id}', '{$transac_id}', '{$transac_type}', '{$cova}', '{$transac_date}',
                                '{$transac_amt}', '{$crunning_b}', '{$trans_created_date}')";
                                $res3 = mysqli_query($connection, $colacctts);
                                if ($res3) {
                                    $colkt = mysqli_query($connection, "SELECT * FROM loan where client_id = '$client_id'");
                                if (count([$colkt]) == 1) {
                                    $kl = mysqli_fetch_array($colkt);
                                    $loan_id = $kl['id'];
                                }
                                } else {
                                    echo "bad data in the last if statement";
                                    if ($connection->error) {
                                        try {
                                            throw new Exception("MYSQL error $connection->error <br> $kdln ", $mysqli->error);
                                        } catch (Exception $e) {
                                            echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
                                            echo ($e->getTraceAsString());
                                        }
                                    }
                                }
                            }
                        } else {
                            echo "bad on client account update";
                        }
                    } else {
                        echo "bad on update client loan status";
                    }
                    } else {
                        if ($connection->error) {
                    try {
                    throw new Exception("MYSQL error $connection->error <br> $iat ", $mysqli->error);
                    } catch (Exception $e) {
                    echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
                    echo ($e->getTraceAsString());
                    }
                }
                        echo "bad on institution account transaction";
                    }
                    } else {
                        echo "bad on institution account update";
                    }
                  } else {
                    $_SESSION["Lack_of_intfund_$randms"] = "This Client Has Been Given Loan Before";
                    header ("Location: ../mfi/lend.php?message=$randms");
                  }
                } else {
                    echo "bad general";
                }
            } else {
                if ($connection->error) {
                    try {
                    throw new Exception("MYSQL error $connection->error <br> $query ", $mysqli->error);
                    } catch (Exception $e) {
                    echo "Error No: ".$e->getCode()." - ".$e->getMessage() . "<br>";
                    echo ($e->getTraceAsString());
                    }
                }
              $_SESSION["Lack_of_intfund_$randms"] = "Sorry Can't Disburse Loan";
              header ("Location: ../mfi/lend.php?message=$randms");
            }
        } else {
            $_SESSION["Lack_of_intfund_$randms"] = "Insufficent Fund From Institution Account! OR This Client Has Been Given Loan Before";
            header ("Location: ../mfi/lend.php?message=$randms");
        }

    }
?>