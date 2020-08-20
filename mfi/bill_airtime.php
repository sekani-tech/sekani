<?php

$page_title = "Bill & Artime";
$destination = "../index.php";
    include("header.php");
    // include("../../functions/connect.php");

?>
<style>
    td{
        text-align: right;
    }
</style>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Bills & Airtime</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                        <th colspan = 2>
                        
                        </th>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Bills Payment</th>
                          <th>Pay Bills - Electricity, Cable Tv e.t.c </th>
                          <td><a href="bill.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Airtime and Data</th>
                          <th> Recharge Airtime and Data.</th>
                          <td><a href="airtime.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
                        <tr>
                          <th>Transaction Pin</th>
                          <th> Generate or Update your Bill & Airtime Transaction pin.</th>
                          <td><a href="bill_pin.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr>
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