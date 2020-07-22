<?php

$page_title = "Approval";
$destination = "approval.php";
    include("header.php");

    $sessint_id = $_SESSION['int_id'];
    $branch_id = $_SESSION['branch_id'];

?>
<?php
if (isset($_GET["message1"])) {
  $key = $_GET["message1"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Transaction Successfully Approved",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
 }
} else if (isset($_GET["message2"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Error updating Cache",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message3"])) {
  $key = $_GET["message2"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "'.$out = $_SESSION["lack_of_intfund_$key"].'",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else if (isset($_GET["message8"])) {
  $key = $_GET["message8"];
  $tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Success",
          text: "Transaction Has Been Declined",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
} else {
  echo "";
}
?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'GET') {
     if (isset($_GET['approve'])) {
         $chq_id = $_GET['approve'];
         $stats = "Approved";

         $users = $_SESSION["user_id"];
          $e = mysqli_query($connection, "SELECT * FROM staff WHERE user_id ='$users'");
          $r = mysqli_fetch_array($e);
          $staff_id = $r['id'];

        $ioio = "SELECT * FROM chq_book WHERE int_id = '$sessint_id' AND id = '$chq_id'";
        $ererr = mysqli_query($connection, $ioio);
        $fdm = mysqli_fetch_array($ererr);
        $client = $fdm['name'];
        $transid = $fdm['transact_id'];
        $book_type = $fdm['book_type'];
        $charges = $fdm['charge_applied'];
        
          $somr = "SELECT * FROM charge WHERE int_id = '$sessint_id' AND id = '$charges'";
        $sdd = mysqli_query($connection, $somr);
        $er = mysqli_fetch_array($sdd);
        $amount = $er['amount'];
        $chname = $er['name'];
        $pay_type = $er['gl_code'];

        $query4 = "SELECT account.id, client.firstname, client.lastname, account.product_id, account.account_no, account.total_withdrawals_derived, account.account_balance_derived FROM client JOIN account ON client.account_no = account.account_no WHERE client.int_id = '$sessint_id' AND client.id ='$client'";
        $queryexec = mysqli_query($connection, $query4);
        $b = mysqli_fetch_array($queryexec);
        $acct_id = $b['id'];
        $accbal = $b['account_balance_derived'];
        $ttl = $b['total_withdrawals_derived'];
        $acct_no = $b['account_no'];
        $sproduct_id = $b['product_id'];
        $clientname = $b['firstname']." ".$b['lastname'];

        $descrip = $chname." charge for ".$clientname;

        $reor = mysqli_query($connection, "SELECT * FROM acc_gl_account WHERE gl_code='$pay_type'");
        $ron = mysqli_fetch_array($reor);
        $glbalance = $ron['organization_running_balance_derived'];

        $newbal = $accbal - $amount;
        $ttlwith = $amount + $ttl;
        $newglball = $amount + $glbalance;

         $iupq = "UPDATE account SET account_balance_derived = '$newbal', last_withdrawal = '$amount', total_withdrawals_derived = '$ttlwith' WHERE id = '$acct_id' AND account_no = '$acct_no' && int_id = '$sessint_id'";
        $iupqres = mysqli_query($connection, $iupq);

        // update the clients transaction
        $trans_type ="debit";
        $irvs = "0";
        $date = date('Y-m-d H:m:s');

         $iat = "INSERT INTO account_transaction (int_id, branch_id,
        account_no, product_id, teller_id, account_id,
        client_id, transaction_id, description, transaction_type, is_reversed,
        transaction_date, amount, running_balance_derived, overdraft_amount_derived,
        created_date, appuser_id, debit) VALUES ('{$sessint_id}', '{$branch_id}',
        '{$acct_no}', '{$sproduct_id}', '{$staff_id}', '{$acct_id}', '{$client}', '{$transid}', '{$descrip}', '{$trans_type}', '{$irvs}',
        '{$date}', '{$amount}', '{$newbal}', '{$amount}',
        '{$date}', '{$users}', {$amount})";
        $res3 = mysqli_query($connection, $iat);

        $upglacct = "UPDATE `acc_gl_account` SET `organization_running_balance_derived` = '$newglball' WHERE int_id = '$sessint_id' && gl_code = '$pay_type'";
        $dbgl = mysqli_query($connection, $upglacct);

                $deiption = "credit";
                $gl_acc = "INSERT INTO gl_account_transaction (int_id, branch_id, gl_code, transaction_id, description,
                transaction_type, teller_id, transaction_date, amount, gl_account_balance_derived, overdraft_amount_derived,
                  created_date, credit) VALUES ('{$sessint_id}', '{$branch_id}', '{$pay_type}', '{$transid}', '{$descrip}', '{$deiption}', '{$staff_id}',
                   '{$date}', '{$amount}', '{$newglball}', '{$amount}', '{$date}', '{$amount}')";
                   $res4 = mysqli_query($connection, $gl_acc);

         $updat = "UPDATE chq_book SET status = '$stats' WHERE id = '$chq_id'";
         $updrgoe = mysqli_query($connection, $updat);


         if ($updrgoe) {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "success",
                    title: "Cheque/Pass Book",
                    text: "Thank You!",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
         } else {
            echo '<script type="text/javascript">
            $(document).ready(function(){
                swal({
                    type: "error",
                    title: "Error in Approving Cheque/Pass Book",
                    text: "Call - The System Support",
                    showConfirmButton: false,
                    timer: 2000
                })
            });
            </script>
            ';
         }
     }  elseif (isset($_GET['delete'])) {
       $id = $_GET['delete'];

       $fdo = "DELETE FROM chq_book WHERE id = '$id'";
       $fidf = mysqli_query($connection, $fdo);
        // //  echo an error that name is not found
        if($fidf){
          echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Cheque/Pass Book Deleted",
                text: "transaction has been deleted",
                showConfirmButton: false,
                timer: 2000
            })
        });
        </script>
        ';
        }
     }
 }
?>
<?php
// right now we will program
// first step - check if this person is authorized

if ($can_transact == 1 || $can_transact == "1") {
?>
<!-- <link href="vendor/css/addons/datatables.min.css" rel="stylesheet">
<script type="text/javascript" src="vendor/js/addons/datatables.min.js"></script> -->
<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">CHQ Book Approval</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php
                   $query = "SELECT * FROM chq_book WHERE int_id = '$sessint_id' && status = 'Pending'";
                   $result = mysqli_query($connection, $query);
                   if ($result) {
                     $inr = mysqli_num_rows($result);
                     if($inr == '0'){ 
                        echo 'No Cheque Books Issued';
                      }else{
                        echo ''.$inr.' Cheque book on the platform';
                      }
                   }
                   ?>  || Approve CHQ Book</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                      <?php
                        $query = "SELECT * FROM chq_book WHERE int_id = '$sessint_id' AND status = 'Pending'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <!-- <th>
                          ID
                        </th> -->
                        <tr>
                        <th class="th-sm">
                          Date
                        </th>
                        <th class="th-sm">
                         Client Name
                        </th>
                        <th class="th-sm">
                         Book Type
                        </th>
                        <th class="th-sm">
                          no of leaves
                        </th>
                        <th class="th-sm">
                          Charges Appli+ed
                        </th>
                        <th class="th-sm">
                          Range Number
                        </th>
                        <th class="th-sm">Status</th>
                        <th>Approval</th>
                        <th>Decline</th>
                        </tr>
                        <!-- <th>Phone</th> -->
                      </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                        <?php $row["id"]; ?>
                          <th><?php echo $row["date"]; ?></th>
                          <?php
                          $idd = $row["name"];
                            $query = "SELECT * FROM client WHERE int_id = '$sessint_id' AND id = '$idd'";
                            $resi = mysqli_query($connection, $query);
                            $c = mysqli_fetch_array($resi);
                            $client_name = $c['display_name'];
                          ?>
                          <th><?php echo $client_name; ?></th>
                          <?php 
                            $ir = $row["book_type"];
                            if($ir == "1"){
                              $ror = "Pass Book";
                            }
                            else if($ir == "2"){
                              $ror = "Cheque Book";
                            }
                          ?>
                          <th><?php echo $ror; ?></th>
                          <th><?php echo $row["leaves_no"]; ?></th>
                          <?php
                          $charge_id = $row["charge_applied"];
                          $dsddf = "SELECT * FROM charge WHERE int_id = '$sessint_id' AND id = '$charge_id'";
                          $fdiofu = mysqli_query($connection, $dsddf);
                          $d = mysqli_fetch_array($fdiofu);
                          $charhes = $d['name'];
                          ?>
                          <th><?php echo $charhes ?></th>
                          <th><?php echo $row["range_amount"]; ?></th>
                          <th><?php echo $row["status"]; ?></th>
                          <td><a href="chq_approval.php?approve=<?php echo $row["id"];?>" class="btn btn-info">Approve</a></td>
                          <td><a href="chq_approval.php?delete=<?php echo $row["id"];?>" class="btn btn-danger">Decline</a></td>
                          </tr>
                          <!-- <th></th> -->
                          <?php }
                          }
                          else {
                            // echo "0 Staff";
                          }
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php

    include("footer.php");

?>
<?php
} else {
  echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Vault Authorization",
    text: "You Dont Have permission to Make Transaction From Vault",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
  // $URL="transact.php";
  // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}

?>
