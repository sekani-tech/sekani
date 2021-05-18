<?php
$page_title = "View Client";
$destination = "client.php";
include('header.php');
?>

<?php
if (isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $update = true;
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $loan_status = $n['loan_status'];
    $last_name = $n['lastname'];
    $acc_no = $n['account_no'];
    $loanofficer_id = $n['loan_officer_id'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $address = $n['ADDRESS'];
    $gender = $n['gender'];
    $date_of_birth = $n['date_of_birth'];
    $branch = $n['branch_id'];
    $fo = mysqli_query($connection, "SELECT name FROM branch WHERE id = '$branch'");
    $e = mysqli_fetch_array($fo);
    $branch_name = $e['name'];
    $country = $n['COUNTRY'];
    $state = $n['STATE_OF_ORIGIN'];
    $lga = $n['LGA'];
    $bvn = $n['BVN'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $id_card = $n['id_card'];
    $passport = $n['passport'];
    $acount = mysqli_query($connection, "SELECT * FROM staff WHERE id='$loanofficer_id'");
    if (count([$acount]) == 1) {
      $j = mysqli_fetch_array($acount);
      $displayname = strtoupper($j['first_name'] . " " . $j['last_name']);
    }
    $signature = $n['signature'];
    $id_img_url = $n['id_img_url'];

    $getacctv = mysqli_query($connection, "SELECT * FROM account WHERE client_id = '$id' && int_id='$sessint_id' ORDER BY id ASC LIMIT 1");
    if (count([$getacctv]) == 1) {
      $xrx = mysqli_fetch_array($getacctv);
      $abd = $xrx['account_balance_derived'];
      $tdd = $xrx['last_deposit'];
      $twd = $xrx['last_withdrawal'];
      $gogo = mysqli_query($connection, "SELECT * FROM loan WHERE client_id = '$id' && int_id='$sessint_id'");
      if (count([$gogo]) == 1) {
        $ppo = mysqli_fetch_array($gogo);
        if (isset($ppo)) {
          $sum = $ppo['total_outstanding_derived'];
          $olb = $ppo['principal_amount'];
          $prd = $ppo['principal_repaid_derived'];
        }
        $cv = "Null";
      }
    }

    $soc = $n["account_no"];
    $length = strlen($soc);
    if ($length == 1) {
      $acc = "000000000" . $soc;
    } elseif ($length == 2) {
      $acc = "00000000" . $soc;
    } elseif ($length == 3) {
      $acc = "00000000" . $soc;
    } elseif ($length == 4) {
      $acc = "0000000" . $soc;
    } elseif ($length == 5) {
      $acc = "000000" . $soc;
    } elseif ($length == 6) {
      $acc = "0000" . $soc;
    } elseif ($length == 7) {
      $acc = "000" . $soc;
    } elseif ($length == 8) {
      $acc = "00" . $soc;
    } elseif ($length == 9) {
      $acc = "0" . $soc;
    } elseif ($length == 10) {
      $acc = $n["account_no"];
    } else {
      $acc = $n["account_no"];
    }
  }
}
?>
<?php
function fill_account($connection)
{
  $int_id = $_SESSION['int_id'];
  $client_id = $_GET['edit'];
  $out = '';
  $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
  $res = mysqli_query($connection, $pen);
  while ($row = mysqli_fetch_array($res)) {
    $product_type = $row["product_id"];
    $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$int_id'");
    while ($mer = mysqli_fetch_array($get_product)) {
      $p_n = $mer["name"];
      $out .= '<option value="' . $row["account_no"] . '">' . $row["account_no"] . ' - ' . $p_n . '</option>';
    }
  }
  return $out;
}
function fill_accounting($connection)
{
  $int_id = $_SESSION['int_id'];
  $client_id = $_GET['edit'];
  $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
  $res = mysqli_query($connection, $pen);
  $out = '';
  while ($row = mysqli_fetch_array($res)) {
    $product_type = $row["product_id"];
    $get_product = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$product_type' AND int_id = '$int_id'");
    while ($mer = mysqli_fetch_array($get_product)) {
      $p_n = $mer["name"];
      $out .= '<option value="' . $row["account_no"] . '">' . $row["account_no"] . ' - ' . $p_n . '</option>';
    }
  }
  return $out;
}
?>

<!-- Add fancyBox -->
<link rel="stylesheet" href="../assets/fancybox-2.1.7/source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="../assets/fancybox-2.1.7/source/jquery.fancybox.js"></script>
<script type="text/javascript" src="../assets/fancybox-2.1.7/source/jquery.fancybox.pack.js"></script>

<style>
  .fileinput .thumbnail {
    display: inline-block;
    margin-bottom: 10px;
    overflow: hidden;
    text-align: center;
    vertical-align: middle;
    max-width: 250px;
    box-shadow: 0 10px 30px -12px rgba(0, 0, 0, .42), 0 4px 25px 0 rgba(0, 0, 0, .12), 0 8px 10px -5px rgba(0, 0, 0, .2);
  }

  .thumbnail {
    border: 0 none;
    border-radius: 4px;
    padding: 0;
  }

  .fileinput .thumbnail>img {
    max-height: 100%;
    width: 100%;
  }

  html * {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  img {
    vertical-align: middle;
    border-style: none;
  }

  .gallery {
    display: inline-block;
  }

  .close-icon {
    border-radius: 50%;
    position: absolute;
    right: 5px;
    top: -10px;
    padding: 0.1px;
    cursor: pointer;
  }
</style>

<!-- Content added here -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Account</h4>
          </div>
          <?php
          if ($ctype == 'INDIVIDUAL' || $ctype == 'GROUP' || $ctype == NULL) {
            // $search = mysqli_query($connection, "SELECT saving_balances_migration.Submitted_On_Date, saving_balances_migration.Approved_On_Date,
            // saving_balances_migration.Activated_On_Date, saving_balances_migration.Loan_Officer_Name,
            // clients_branch_migrate.last_depost, clients_branch_migrate.available_balance,
            // clients_branch_migrate.name, saving_balances_migration.Account_No, clients_branch_migrate.outstanding_loan_balance
            // FROM saving_balances_migration
            // INNER JOIN clients_branch_migrate ON saving_balances_migration.Client_Name = clients_branch_migrate.name WHERE clients_branch_migrate.name = '$display_name' LIMIT 1");
            // $migrate = mysqli_fetch_array($search, MYSQLI_ASSOC)
          ?>
            <div class="card-body">
              <form action="">
                <div class="form-group">
                  <label for="">Name:</label>
                  <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $display_name; ?>" readonly name="display_name">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Account No:</label>
                      <?php
                      if (fill_account($connection) == "") {
                      ?>
                        <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $migrate['Account_No']; ?>" readonly name="display_name">
                      <?php
                      } else {
                      ?>
                        <select id="account" class="form-control">
                          <?php echo fill_account($connection); ?>
                        </select>
                      <?php
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Account Officer:</label>
                      <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $displayname; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Account Type:</label>
                      <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $ctype; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Total Outstanding Loan Balance:</label>
                      <?php
                      $prin_query = "SELECT SUM(principal_amount) AS total_out_prin FROM loan_repayment_schedule WHERE (int_id = '$sessint_id' AND installment >= 1) AND client_id = '$id'";
                      $int_query = "SELECT SUM(interest_amount) AS total_int_prin FROM loan_repayment_schedule WHERE (int_id = '$sessint_id' AND installment >= 1) AND client_id = '$id'";
                      // LOAN ARREARS
                      $arr_query1 = mysqli_query($connection, "SELECT SUM(principal_amount) AS arr_out_prin FROM loan_arrear WHERE (int_id = '$sessint_id' AND installment >= 1 )AND client_id = '$id'");
                      $arr_query2 = mysqli_query($connection, "SELECT SUM(interest_amount) AS arr_out_int FROM loan_arrear WHERE (int_id = '$sessint_id' AND installment >= 1) AND client_id = '$id'");
                      // check the arrears
                      $ar = mysqli_fetch_array($arr_query1);
                      $arx = mysqli_fetch_array($arr_query2);
                      $arr_p = $ar["arr_out_prin"];
                      $arr_i = $arx["arr_out_int"];
                      $pq = mysqli_query($connection, $prin_query);
                      $iq = mysqli_query($connection, $int_query);
                      $pqx = mysqli_fetch_array($pq);
                      $iqx = mysqli_fetch_array($iq);
                      // check feedback
                      $print = $pqx['total_out_prin'];
                      $intet = $iqx['total_int_prin'];
                      // $fde = ($print + $intet) + ($arr_p + $arr_i);
                      $fde = $print + $intet;
                      ?>
                      <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="NGN - <?php echo number_format(round($fde), 2); ?>" readonly>
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Loan Status:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $loan_status; ?>" readonly>
                        </div>
                      </div> -->
                  <script>
                    $(document).ready(function() {
                      $('#account').on("change", function() {
                        var id = $(this).val();
                        $.ajax({
                          url: "ajax_post/client_view_acc.php",
                          method: "POST",
                          data: {
                            id: id
                          },
                          success: function(data) {
                            $('#soe').html(data);
                          }
                        })
                      });
                    });
                  </script>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Mobile Number:</label>
                      <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $phone; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">BVN:</label>
                      <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $bvn; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row" id="soe">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Account Balance:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php if ($abd == "") {
                                                                                                                            echo $migrate['available_balance'];
                                                                                                                          } else {
                                                                                                                            echo $abd;
                                                                                                                          } ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Deposit:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php if ($tdd == "") {
                                                                                                                            echo $migrate['last_depost'];
                                                                                                                          } else {
                                                                                                                            echo $tdd;
                                                                                                                          } ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Avaliable Balance:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php if ($abd == "") {
                                                                                                                            echo $migrate['available_balance'];
                                                                                                                          } else {
                                                                                                                            echo $abd;
                                                                                                                          } ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="">Last Withdrawal:</label>
                          <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $twd; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <a href="update_client.php?edit=<?php echo $id; ?>" class="btn btn-primary">Edit Client</a>
                <a href="add_account.php?edit=<?php echo $id; ?>" class="btn btn-primary"> Add Account to client</a>

              </form>
            </div>
          <?php
          } else if ($ctype == 'CORPORATE') {
            $id = $_GET["edit"];
            $update = true;
            $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
            if (count([$person]) == 1) {
              $t = mysqli_fetch_array($person);
              $emaila = $t['email_address'];
              $dob = $t['date_of_birth'];
              $rc_number = $t['rc_number'];
              $sig_one = $t['sig_one'];
              $sig_two = $t['sig_two'];
              $sig_three = $t['sig_three'];
              $sig_address_one = $t['sig_address_one'];
              $sig_address_two = $t['sig_address_two'];
              $sig_address_three = $t['sig_address_three'];
              $sig_phone_one = $t['sig_phone_one'];
              $sig_phone_two = $t['sig_phone_two'];
              $sig_phone_three = $t['sig_phone_three'];
              $sig_gender_one = $t['sig_gender_one'];
              $sig_gender_two = $t['sig_gender_two'];
              $sig_gender_three = $t['sig_gender_three'];
              $sig_state_one = $t['sig_state_one'];
              $sig_state_two = $t['sig_state_two'];
              $sig_state_three = $t['sig_state_three'];
              $sig_lga_one = $t['sig_lga_one'];
              $sig_lga_two = $t['sig_lga_two'];
              $sig_lga_three = $t['sig_lga_three'];
              $sig_occu_one = $t['sig_occu_one'];
              $sig_occu_two = $t['sig_occu_two'];
              $sig_occu_three = $t['sig_occu_three'];
              $sig_bvn_one = $t['sig_bvn_one'];
              $sig_bvn_two = $t['sig_bvn_two'];
              $sig_bvn_three = $t['sig_bvn_three'];
              $l_officer = $t['loan_officer_id'];
              $acount = mysqli_query($connection, "SELECT * FROM staff WHERE id='$l_officer'");
              if (count([$acount]) == 1) {
                $r = mysqli_fetch_array($acount);
                $acc_off = strtoupper($r['first_name'] . " " . $j['last_name']);
              }
            }
          ?>
            <div class="card-body">
              <div class="form-group">
                <label for="">Registered Name:</label>
                <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $display_name; ?>" readonly name="display_name">
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">RC Number:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $rc_number; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Account Number:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $acc; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Date of Registration:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $dob; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Email Address:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $emaila; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Account Officer:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $acc_off; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Registered Address:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $address; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Name of Signatries NO1:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_one; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Name of Signatries NO2:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_two; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Name of Signatries NO3:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_three; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Phone No:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_phone_one; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Phone No:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_phone_two; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Phone No:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_phone_three; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">BVN:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_bvn_one; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">BVN:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_bvn_two; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">BVN:</label>
                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $sig_bvn_three; ?>" readonly>
                  </div>
                </div>
                <a href="update_client.php?edit=<?php echo $id; ?>" class="btn btn-primary">Edit CLient</a>
              </div>
            </div>
          <?php
          } ?>

        </div>

        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Generate Account Report</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="client_statement.php">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Start Date:</label>
                    <input type="text" name="id" class="form-control" hidden value="<?php echo $id; ?>">
                    <input type="date" name="start" id="" class="form-control" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">End Date:</label>
                    <input type="date" name="end" id="" class="form-control" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Account No:</label>
                    <?php
                    if (fill_account($connection) == "") {
                    ?>
                      <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $migrate['Account_No']; ?>" readonly name="display_name">
                    <?php
                    } else {
                    ?>
                      <select id="account" name="account_id" class="form-control">
                        <?php echo fill_account($connection); ?>
                      </select>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Generate Account Report</button>

            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <!-- Dialog box for signature -->
        <style>
          .fluidImage {
            max-width: 100%;
            max-height: auto;
          }
        </style>
        <div id="sig" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo $first_name; ?></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img src="../functions/clients/sign/<?php echo $signature; ?>" class="fluidImage" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLong-sig">
                  Update
                </button>


              </div>
            </div>
          </div>
        </div>
        <!-- dialog ends -->
        <!-- Dialog box for passport -->
        <div id="pas" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo $first_name; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img src="../functions/clients/passport/<?php echo $passport; ?>" class="fluidImage" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLong-pas">
                  Update
                </button>


              </div>
            </div>
          </div>
        </div>
        <!-- dialog ends -->
        <!-- Dialog box for id img -->
        <div id="id" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><?php echo $first_name; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <img src="../functions/clients/id/<?php echo $id_img_url; ?>" class="fluidImage" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalLong">
                  Update
                </button>


              </div>
            </div>
          </div>
        </div>
        <!-- dialog ends -->

        <!-- Modal ID update -->
        <form action="../functions/clients/mandate_update.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <div id="uploadModal"></div>
                  <h5 class="modal-title" id="exampleModalLongTitle">Update ID </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <style>
                      input.prev[type="file"] {
                        display: none;
                      }

                      .custom-file-upload {
                        border: 1px solid #ccc;
                        display: inline-block;
                        padding: 6px 12px;
                        cursor: pointer;
                      }

                      .fileinput .thumbnail {
                        display: inline-block;
                        margin-bottom: 10px;
                        overflow: hidden;
                        text-align: center;
                        vertical-align: middle;
                        max-width: 250px;
                        box-shadow: 0 10px 30px -12px rgba(0, 0, 0, .42), 0 4px 25px 0 rgba(0, 0, 0, .12), 0 8px 10px -5px rgba(0, 0, 0, .2);
                      }

                      .thumbnail {
                        border: 0 none;
                        border-radius: 4px;
                        padding: 0;
                      }

                      .btn {
                        padding: 10px 10px;
                      }

                      .fileinput .thumbnail>img {
                        max-height: 100%;
                        width: 100%;
                      }

                      html * {
                        -webkit-font-smoothing: antialiased;
                        -moz-osx-font-smoothing: grayscale;
                      }

                      img {
                        vertical-align: middle;
                        border-style: none;
                      }
                    </style>

                    <div class="col-md-4">
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <label for="file-upload" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <input id="file-upload" name="id_card" type="file" class="inputFileHidden prev" required />
                        <label id="upload"> Select ID</label>
                        <div id="upload"></div>
                        <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                      </div>
                    </div>
                    <input type="text" value="<?php echo $id; ?>" name="client_id" hidden>

                    <script>
                      var changeq = document.getElementById('file-upload');
                      var check2 = document.getElementById('upload');
                      changeq.addEventListener('change', showme);

                      function showme(event) {
                        var one = event.srcElement;
                        var fname = one.files[0].name;
                        check2.textContent = 'ID: ' + fname;
                      }
                    </script>

                    <div class="col-md-4">
                      <label for="">Select ID</label>
                      <select class="form-control" name="id_type">
                        <option value="<?php echo $id_card ?>"><?php echo $id_card ?></option>
                        <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="International Passport">International Passport</option>
                        <option value="Drivers Liscense">Drivers Liscense</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>

            </div>
          </div>
        </form>
        <!-- upload modal -->
        <!-- signature -->
        <form action="../functions/clients/mandate_update.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="modal fade" id="exampleModalLong-sig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Update Signature </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="col-md-4">
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <label for="file-upload-sig" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <input id="file-upload-sig" name="signature" type="file" class="inputFileHidden prev" required />
                        <label id="upload-sig"> Select Signature</label>
                        <div id="upload-sig"></div>
                        <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                      </div>
                    </div>
                    <input type="text" value="<?php echo $id; ?>" name="client_id" hidden>

                    <script>
                      var changeq = document.getElementById('file-upload-sig');
                      var check2 = document.getElementById('upload-sig');
                      changeq.addEventListener('change', showme);

                      function showme(event) {
                        var one = event.srcElement;
                        var fname = one.files[0].name;
                        check2.textContent = 'Signature: ' + fname;
                      }
                    </script>

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>

            </div>
          </div>
        </form>
        <!-- /signature -->
        <!-- passport update -->
        <form action="../functions/clients/mandate_update.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="modal fade" id="exampleModalLong-pas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Update Passport </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="col-md-4">
                      <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <label for="file-upload-pas" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <input id="file-upload-pas" name="passport" type="file" class="inputFileHidden prev" required />
                        <label id="upload-pas"> Select Passport</label>
                        <div id="upload-pas"></div>
                        <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                      </div>
                    </div>
                    <input type="text" value="<?php echo $id; ?>" name="client_id" hidden>

                    <script>
                      var changeq = document.getElementById('file-upload-pas');
                      var check2 = document.getElementById('upload-pas');
                      changeq.addEventListener('change', showme);

                      function showme(event) {
                        var one = event.srcElement;
                        var fname = one.files[0].name;
                        check2.textContent = 'Passport: ' + fname;
                      }
                    </script>

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>

            </div>
          </div>
        </form>
        <!-- /passport -->
        <div class="card card-profile">
          <div class="card-avatar">
            <a data-toggle="modal" class="mode" data-target="#pas">
              <img class="img" src="../functions/clients/passport/<?php echo $passport; ?>" />
            </a>
          </div>
          <!-- Get client data -->
          <div class="card-body">
            <h6 class="card-category text-gray">Clients Profile Picture</h6>
            <h4 class="card-title"><?php echo $display_name; ?></h4>
            <p class="card-description">
              <?php echo $branch_name; ?>
            </p>
            <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
          </div>
        </div>
        <div class="card card-profile">
          <div class="card-avatar">
            <a data-toggle="modal" class="mode" data-target="#id">
              <img class="img" src="../functions/clients/id/<?php echo $id_img_url; ?>" />
            </a>
          </div>
          <!-- Get session data and populate user profile -->
          <div class="card-body">
            <h6 class="card-category text-gray">ID Card</h6>
            <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
          </div>
        </div>
        <!-- /id card -->
        <div class="card card-profile">
          <div class="card-avatar">
            <a data-toggle="modal" class="mode" data-target="#sig">
              <img class="img" src="../functions/clients/sign/<?php echo $signature; ?>" />
            </a>
          </div>
          <!-- Get session data and populate user profile -->
          <div class="card-body">
            <h6 class="card-category text-gray">Signature</h6>
            <!-- <a href="#pablo" class="btn btn-primary btn-round">Follow</a> -->
          </div>
        </div>
        <!-- signature -->


        <form action="client_image_upload.php" method="POST" enctype="multipart/form-data">

          <?php
          if (!empty($_SESSION['error'])) {
            echo "
                <script>
                  swal('{$_SESSION['error']}', ' ', 'error', {
                    button: false,
                    timer: 2000
                  });
                </script>";
            unset($_SESSION['error']);
          }
          ?>

          <?php
          if (!empty($_SESSION['success'])) {
            echo "
                <script>
                  swal('{$_SESSION['success']}', ' ', 'success', {
                    button: false,
                    timer: 2000
                  });
                </script>";
            unset($_SESSION['success']);
          }
          ?>

          <div class="card card-profile pb-3">

            <div class="card-body">

              <h6 class="card-category text-gray">Upload Image File</h6>

              <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>

                <div class="row">

                  <div class="col-10">
                    <input type="file" name="image" class="form-control" />
                  </div>
                  <div class="col-">
                    <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput">
                      <i class="material-icons">clear</i>
                    </a>
                  </div>

                </div>

                <div class="row">

                  <div class="col-12">
                    <button type="submit" id="upload-image" class="btn btn-primary">Upload</button>
                  </div>

                </div>

                <input type="hidden" name="client_id" value="<?php echo $_GET['edit']; ?>">

              </div>

            </div>

          </div>

      </div>

      </form>

      <div class="col-md-8">

        <?php
        $client_id = $_GET['edit'];
        $sql = "SELECT * FROM client_uploads WHERE client_id = '$client_id'";
        $images = mysqli_query($connection, $sql);

        if (mysqli_num_rows($images) > 0) {
        ?>

          <div class="card">

            <div class="card-body">

              <div class="row">

                <?php
                while ($image = mysqli_fetch_assoc($images)) {
                ?>
                  <div class='col-md-4 mt-3'>
                    <a class="fancybox" rel="group" href="uploads/<?php echo $image['image'] ?>">
                      <img class="img-fluid" alt="" src="uploads/<?php echo $image['image'] ?>" />
                    </a>
                    <form action="client_image_delete.php" method="POST">
                      <input type="hidden" name="id" value="<?php echo $image['id'] ?>">
                      <input type="hidden" name="client_id" value="<?php echo $_GET['edit']; ?>">
                      <button type="submit" id="delete-image" class="close-icon" onclick="return confirm('Are you sure you want to delete this image?')">
                        <i class="material-icons">clear</i>
                      </button>
                    </form>
                  </div>
                <?php } ?>

              </div>

            </div>

          </div>

        <?php } ?>

      </div>

    </div>

  </div>

</div>

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".fancybox").fancybox({
      openEffect: "none",
      closeEffect: "none"
    });

    $("#delete-image").click(function() {

    });
  });
</script>

<?php

include('footer.php');

?>