<?php

$page_title = "Configuration";
$destination = "../index.php";
include("header.php");

// If it is successfull, It will show this message
if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Registration Successful",
          text: "Awaiting Approval of New client",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} // If it is not successfull, It will show this message
else if (isset($_GET["message2"])) {
    $key = $_GET["message2"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        // $out = $_SESSION["lack_of_intfund_$key"];
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Error during Registration",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
if (isset($_GET["message3"])) {
    $key = $_GET["message3"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Success",
        text: "Client was Updated successfully!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
$(document).ready(function(){
  swal({
      type: "error",
      title: "Error",
      text: "Error updating client!",
      showConfirmButton: false,
      timer: 2000
  })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message5"])) {
    $key = $_GET["message5"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "success",
        title: "Success",
        text: "Client Closed!",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}

?>

<!-- Content added here -->

<style>
    .card .card-body {
        padding: 0.9375rem 20px;
        position: relative;
        height: 200px;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-center">Configuration</h4>
                <p class="card-category text-center"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary" style="height: auto;">
                    <div class="card-body ">

                        <h4 class="card-title">Asset Depreciation</h4>
                        <p class="card-description">
                            Setup the Depreciation Value for the Assets in the institution
                        </p>
                        <a href="dep_setup.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Products</h4>
                        <p class="card-description">
                            Add, edit and update the Loan products of the instution
                        </p>

                        <a href="products_config.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ml-auto mr-auto">

                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Staff Management</h4>
                        <p class="card-description">
                            Manage all the staff activities and their status
                        </p>
                        <a href="staff_mgmt.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Branch</h4>
                        <p class="card-description">
                            View and create institution branches
                        </p>
                        <a href="branch.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">SMS/Email Campaign</h4>
                        <p class="card-description">
                            Handle the alerts that the system recieves
                        </p>
                        <a href="alert.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ml-auto mr-auto">

                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">SEKANI WALLET</h4>
                        <p class="card-description">
                            Fund Institution Sekani Wallet, Keep Activity Up to Date
                        </p>
                        <a href="wallet.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Loan Reconciliation</h4>
                        <p class="card-description">
                            Edit and make sure the loan balances match at the end of a particular accounting period.
                        </p>
                        <a href="loan_reconciliation.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


            <div class="col-md-4 ml-auto mr-auto">
                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Track Dormancy</h4>
                        <p class="card-description">
                            Keep track of all Accounts that have not been in use
                        </p>
                        <a href="trk_dormant.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ml-auto mr-auto">

                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Bulk Update</h4>
                        <p class="card-description">
                            Upload Bulk data from institution database
                        </p>
                        <a href="bulk_update.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>



            <!-- create accounts without bvn -->
            <?php
            //  function to check likes
            function like($str, $searchTerm)
            {
                $searchTerm = strtolower($searchTerm);
                $str = strtolower($_SESSION['username']);
                $pos = strpos($str, $searchTerm);
                if ($pos === false)
                    return false;
                else
                    return true;
            }

            $found = like('it-support', 'it-su'); //returns true
            $notFound = like('Apple', 'lep'); //returns false

            if ($found) {
            ?>

                <div class="col-md-4 ml-auto mr-auto">

                    <div class="card card-pricing bg-primary">
                        <div class="card-body ">

                            <h4 class="card-title">Create client</h4>
                            <p class="card-description">
                                Create client with BVN
                            </p>
                            <a href="client_create.php" class="btn btn-white btn-round">View</a>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>

        </div>

        <div class="row">
            <div class="col-md-4 ml-auto mr-auto">

                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Clients Transfer</h4>
                        <p class="card-description">
                            Transfer Clients to Different Branch or Acct Officer
                        </p>
                        <a href="client_transfer.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>


            <div class="col-md-4 ml-auto mr-auto">

                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Staff Transfer</h4>
                        <p class="card-description">
                            Transfer Staff to Different Branch
                        </p>
                        <a href="staff_transfer.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ml-auto mr-auto">

                <div class="card card-pricing bg-primary">
                    <div class="card-body ">

                        <h4 class="card-title">Migrations</h4>
                        <p class="card-description">
                            Migrate your institution data into our system
                        </p>
                        <a href="migrations.php" class="btn btn-white btn-round">View</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
                <div class="col-md-4 ml-auto mr-auto">

                    <div class="card card-pricing bg-primary">
                        <div class="card-body ">

                            <h4 class="card-title">Budget Setup</h4>
                            <p class="card-description">
                                Create Institution Budget
                            </p>
                            <a href="budget_setup.php" class="btn btn-white btn-round">View</a>
                        </div>
                    </div>
                </div>
            </div>


    </div>
</div>

<?php

include("footer.php");

?>