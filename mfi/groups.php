<?php

$page_title = "Group";
$destination = "index.php";
    include("header.php");

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
          title: "Group Created",
          text: "",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message2"])) {
$key = $_GET["message2"];
// $out = $_SESSION["lack_of_intfund_$key"];
$tt = 0;
  if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
echo '<script type="text/javascript">
$(document).ready(function(){
    swal({
        type: "error",
        title: "Error Creating Group",
        text: "Contact TechSupport.",
        showConfirmButton: false,
        timer: 2000
    })
});
</script>
';
$_SESSION["lack_of_intfund_$key"] = 0;
}
}
else if (isset($_GET["message3"])) {
  $key = $_GET["message3"];
  // $out = $_SESSION["lack_of_intfund_$key"];
  $tt = 0;
    if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
  echo '<script type="text/javascript">
  $(document).ready(function(){
      swal({
          type: "success",
          title: "Group Updated",
          text: "Contact TechSupport.",
          showConfirmButton: false,
          timer: 2000
      })
  });
  </script>
  ';
  $_SESSION["lack_of_intfund_$key"] = 0;
  }
  }
  else if (isset($_GET["message4"])) {
    $key = $_GET["message4"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    $tt = 0;
      if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "error",
            title: "Error Updating Group",
            text: "Contact TechSupport.",
            showConfirmButton: false,
            timer: 2000
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
              title: "Group Closed",
              text: "",
              showConfirmButton: false,
              timer: 2000
          })
      });
      </script>
      ';
      $_SESSION["lack_of_intfund_$key"] = 0;
      }
      }
      else if (isset($_GET["message6"])) {
        $key = $_GET["message6"];
        // $out = $_SESSION["lack_of_intfund_$key"];
        $tt = 0;
          if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error Closing Group",
                text: "Contact TechSupport.",
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
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <!-- <span class="nav-tabs-title">Configuration:</span> -->
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <!-- <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Password Settings
                            <div class="ripple-container"></div>
                          </a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link active" href="#products" data-toggle="tab">
                          <!-- visibility -->
                            <i class="material-icons">supervisor_account</i> Groups
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            <i class="material-icons">supervised_user_circle</i> Pending Approval
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#perform" data-toggle="tab">
                            <i class="material-icons">remove_circle</i> Closed Groups
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="products">
                      <a href="create_group.php" class="btn btn-primary"> Create a Group</a>
                      <?php include("items/group_list.php"); ?>
                      <!-- items report -->
                    </div>
                    <!-- /items report-->
                    <div class="tab-pane" id="messages">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/pending_group.php"); ?>
                    </div>
                    <div class="tab-pane" id="perform">
                    <!-- <a href="create_charge.php" class="btn btn-primary"> Schedule of Deposit Structure and Maturity Profile</a> -->
                      <?php include("items/closed_group.php"); ?>
                    </div>
                    
                    <!-- /maturity profile -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / -->
        </div>
      </div>

<?php

    include("footer.php");

?>