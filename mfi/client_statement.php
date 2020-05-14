<?php

$page_title = "Client Statement";
$destination = "client.php";
include('header.php');

if(isset($_GET["edit"])) {
  $id = $_GET["edit"];
  $person = mysqli_query($connection, "SELECT * FROM client WHERE id='$id' && int_id ='$sessint_id'");
  if (count([$person]) == 1) {
    $n = mysqli_fetch_array($person);
    $ctype = $n['client_type'];
    $branch = $n['branch_id'];
    $display_name = $n['display_name'];
    $first_name = $n['firstname'];
    $middle_name = $n['middlename'];
    $last_name = $n['lastname'];
    $acc_no = $n['account_no'];
    $actype = $n['account_type'];
    $phone = $n['mobile_no'];
    $phone2 = $n['mobile_no_2'];
    $email = $n['email_address'];
    $date_of_birth = $n['date_of_birth'];
    $sms_active = $n['SMS_ACTIVE'];
    $email_active = $n['EMAIL_ACTIVE'];
    $query2 = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$sessint_id'");
        if (count([$query2]) == 1) {
            $b = mysqli_fetch_array($query2);
            $intname = $b['int_name'];
            $logo = $b['int_name'];
            $full = $b['int_full'];
            $web = $b['website'];
        }
    $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
    if (count([$branchid]) == 1) {
      $a = mysqli_fetch_array($branchid);
      $branch_name = strtoupper($a['name']);
      $branch_address = $a['location'];
    }
    $acount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
    if (count([$acount]) == 1) {
      $b = mysqli_fetch_array($acount);
      $currtype = $b['currency_code'];
    }

      $totald = mysqli_query($connection,"SELECT SUM(debit)  AS debit FROM account_transaction WHERE client_id = '$id'");
      $deb = mysqli_fetch_array($totald);
      $tdp = $deb['debit'];
      $totaldb = number_format($tdp, 2);

      $totalc = mysqli_query($connection, "SELECT SUM(credit)  AS credit FROM account_transaction WHERE client_id = '$id'");
      $cred = mysqli_fetch_array($totalc);
      $tcp = $cred['credit'];
      $totalcd = number_format($tcp, 2);
  }
}

// session_start();
                            
//     // Store data in session variables
//     session_regenerate_id();
    $_SESSION["loggedin"] = true;
    $_SESSION["client_id"] = $id;
?>
<!-- Content added here -->
<!-- print content -->
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <div style="padding-left:20px;" class="card">
              <div class="row">
              </div>
          <div class="card">
            <!-- <div class="card-header card-header-primary">
              <h4 class="card-title">Account Statement Preview</h4>
            </div> -->
            <link rel="stylesheet" media="print"  href="../composer/pdf/util.css">
            <div class="card-body">
            <div class="form-group">
              <a href="../composer/client_statement.php?edit=<?php echo $id;?>" class="btn btn-primary pull-left">Download PDF</a>
                </div>
                <div>
                <header class="clearfix">
                  <div id="logo">
                    <img src="<?php echo $_SESSION["int_logo"];?>" height="80" width="80">
                  </div>
                  <h1><?php echo $full;?><br/> Client Statement</h1>
                  <div id="project" >
                    <div class="row">
                    <div class="col-md-6">
                        <h6 >Branch name</h6>
                          <h4><?php echo $branch_name;?></h4>
                        <h6 >Currency</h6>
                          <h4><?php echo $currtype;?></h4>
                          <h6 >Account number</h6>
                        <h4><?php echo $acc_no;?></h4> 
                    </div>
                    <div class="col-md-6">
                    <h6 >Client name</h6>
                          <h4><?php echo $first_name," ", $last_name;?></h4>
                          <h6 >Total debit</h6>
                          <h4>&#8358;<?php echo $totaldb;?></h4>
                        <h6 >Total credit</h6>
                          <h4>&#8358;<?php echo $totalcd;?></h4>
                    </div>
                  </div>
                    </div>
                  </div>
                </header>

    <div class="ody">
        <div class="wrap-table100">
            <div class="table100">
            <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                </script>
            <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                        <thead>
                        <?php
                         $query = "SELECT * FROM account_transaction WHERE client_id ='$id'";
                        $result = mysqli_query($connection, $query);
                      ?>
                        <tr class="table100-head">
                            <th class="column1">Transaction-Date</th>
                            <th class="column2">Value Date</th>
                            <th class="column3">Reference</th>
                            <th class="column4">Debits(&#8358;)</th>
                            <th class="column5">Credits(&#8358;)</th>
                            <th class="column6">Balance(&#8358;)</th>
                        </tr>
                    </thead>
                      <tbody>
                      <?php if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {?>
                        <tr>
                          <td class="column1"><?php echo $row["transaction_date"]; ?></td>
                          <td class="column2"><?php echo $row["created_date"]; ?></td>
                          <td class="column3"><?php echo $row["transaction_id"]; ?></td>
                          <td class="column4"><?php echo $row["debit"]; ?></td>
                          <td class="column5"><?php echo $row["credit"]; ?></td>
                          <td class="column6"><?php echo $row["running_balance_derived"]; ?></td>
                        </tr>
                        <?php }
                          }
                          else {
                            // echo "0 Document";
                          }
                          ?>
                          <!-- <th></th> -->
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
                </div>
            </div>
          
            </div>
          </div>
        </div>
        
    </div>
  </div>
    </div>
</div>
<style>
  
.clearfix:after {
  content: "";
  display: table;
  clear: both;
  position: relative;
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

.ody {
  position: relative;
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  clear: both;
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  font-weight: normal;
  color: #5D6975;
}
h4{
  font-weight: normal;
  color: #5D6975;
  font-size: 1.4em;
}
#company {
  float: right;
  text-align: right;
}
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: left;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: left;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

</style>
<?php

include('footer.php');

?>