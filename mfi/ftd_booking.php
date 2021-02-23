<?php

$page_title = "FTD Booking";
$destination = "branch.php";
include("header.php");

if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error!",
          text: "Kindly fill all required data",
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
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error",
        text: "Client Branch Could Not be Found, Kindly ensure Clients data is up to date",
        showConfirmButton: true,
        timer: 2000
    })
});
</script>
';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
} else if (isset($_GET["message3"])) {
    $key = $_GET["message3"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "error",
          title: "Error",
          text: "Something is Wrong with Client account or Client account is Missing",
          showConfirmButton: true,
          timer: 3000
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
            type: "success",
            title: "Success",
            text: "FTD successfully boked and Awaiting Approval",
            showConfirmButton: true,
            timer: 3000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}
else if (isset($_GET["message5"])) {
    $key = $_GET["message5"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "FTD successfully boked and Awaiting Approval. This account is not sufficiently funded kindly fund
            before attempting to approve",
            showConfirmButton: true,
            timer: 3000
        })
    });
    </script>
    ';
        $_SESSION["lack_of_intfund_$key"] = 0;
    }
}

/**
 * A branch function that returns the result in html option
 * passing branch id in value and name for display
 *
 * @param $connection
 * @return string
 */

function fill_branch($connection)
{
    $sint_id = $_SESSION["int_id"];
    $org = "SELECT * FROM branch WHERE int_id = '$sint_id'";
    $res = mysqli_query($connection, $org);
    $output = '';
    while ($row = mysqli_fetch_array($res)) {
        $output .= '<option value = "' . $row["id"] . '"> ' . $row["name"] . ' </option>';
    }
    return $output;
}

function fill_in($connection)
{
    $sint_id = $_SESSION["int_id"];
    $org = "SELECT * FROM `acc_gl_account` WHERE 
                        int_id = '$sint_id' AND 
                        parent_id !='0' AND 
                        classification_enum = '1' AND
                        disabled = '0' ORDER BY name ASC";
    $res = mysqli_query($connection, $org);
    $output = '';
    while ($row = mysqli_fetch_array($res)) {
        $output .= '<option value = "' . $row["gl_code"] . '"> ' . $row["name"] . ' </option>';
    }
    return $output;
}

/**
 *
 * @param $connection
 * @return string
 */
function fill_state($connection)
{
    $org = "SELECT * FROM states";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res)) {
        $out .= '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
    }
    return $out;
}

/**
 * fetch data from savings_product related to an institution
 * passing insti_id and accounting type
 * returning the id in value and the name as show
 * @param $connection
 * @return string
 */
function fill_savings($connection)
{
    $sint_id = $_SESSION["int_id"];
    $org = "SELECT * FROM savings_product WHERE int_id = '$sint_id' AND accounting_type='3'";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res)) {
        $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
    }
    return $out;
}

/**
 * A function that fill client from the client table with a Join to branch table
 * using client.branch_id on branch id
 * pass the result in a select option tag
 * value is client id and display a concatenation of first,middle and last name
 *
 * @param $connection
 * @return string
 */
function fill_client($connection)
{
    $sint_id = $_SESSION["int_id"];
    $branc = $_SESSION["branch_id"];
    $org = "SELECT client.id, client.firstname, 
                client.lastname, client.middlename FROM client
                 JOIN branch ON client.branch_id = branch.id 
                 WHERE client.int_id = '$sint_id' AND 
                 (branch.id = '$branc' OR branch.parent_id = '$branc') 
                 AND status = 'Approved' ORDER BY firstname ASC";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res)) {
        $out .= '<option value="' . $row["id"] . '">' . strtoupper($row["firstname"]) . " " . strtoupper($row["middlename"]) . " " . strtoupper($row["lastname"]) . '</option>';
    }
    return $out;
}

?>



<!-- Content added here -->
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">FTD Booking</h4>
                        <p class="card-category">Fill in all important data</p>
                    </div>
                    <div class="card-body">
                        <form action="../functions/ftd/ftd_upload.php" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="bmd-label-floating">Savings Product*:</label>
                                    <select name="s_product" id="sav_prod_id" class="form-control">
                                        <option value="">select an option</option>
                                        <!--                                            Returning the option from fill_saving function-->
                                        <?php echo fill_savings($connection); ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="bmd-label-floating">Client Account No*:</label>
                                    <select name="client" class="form-control" id="collat">
                                        <option value="">select an option</option>
                                        <!--                                            Output is displayed here from fill_client function-->
                                        <?php echo fill_client($connection); ?>
                                    </select>
                                </div>
                            </div>

                            <!--                                display Script Information -->
                            <div class="row" id="ddjf"></div>
                            <button type="submit" class="btn btn-primary pull-right">Book FTD</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /content -->
    </div>
</div>

<!--not functioning yet-->
<script>
    $(document).ready(function() {
        $('#static').on("change", function() {
            var id = $(this).val();
            $.ajax({
                url: "ajax_post/lga.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#showme').html(data);
                }
            })
        });
    });
</script>
<!--                      fill Client Name Script-->
<script>
    $(document).ready(function() {
        $('#collat').on("change", function() {
            var id = $(this).val();
            var sav_id = $('#sav_prod_id').val();
            $.ajax({
                url: "ajax_post/ftd_option.php",
                method: "POST",
                data: {
                    id: id,
                    sav_id: sav_id
                },
                success: function(data) {
                    $('#ddjf').html(data);
                }
            })
        });
    });

    // Saving Product It
    $(document).ready(function() {
        $('#sav_prod_id').on("change", function() {
            var id = $('#collat').val();
            var sav_id = $(this).val();
            $.ajax({
                url: "ajax_post/ftd_option.php",
                method: "POST",
                data: {
                    id: id,
                    sav_id: sav_id
                },
                success: function(data) {
                    $('#ddjf').html(data);
                }
            })
        });
    });
</script>
<!--                      End of fill client Name Script-->
<?php
include("footer.php");

?>