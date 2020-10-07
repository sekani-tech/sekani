  <?php

   $page_title = "Bulk Update";
   $destination = "configuration.php";
   include("header.php");
  
  ?>  


<!-- Content added here -->
<div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Bulk Update</h4>
              
                  <!-- Insert number users institutions -->
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                  <table class="rtable display nowrap" style="width:100%">
                      <thead class=" text-primary">
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                          
                          <th>Charge Data</th>
                          <th>Upload Institution Charge data</th>
                          <td><a href="bulk_charge_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Client Data</th>
                          <th>Upload Institution Client data</th>
                          <td><a href="bulk_client_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>General Lender Data</th>
                          <th>Upload Institution General Lender data</th>
                          <td><a href="bulk_general_lender_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Group Data</th>
                          <th>Upload Institution Group data</th>
                          <td><a href="bulk_group_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Loan Data</th>
                          <th>Upload Institution Loan data</th>
                          <td><a href="bulk_loan_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <!-- <tr>
                          <th>General Ledger Template</th>
                          <th>Assign General Ledgers to system posting activities</th>
                          <td><a href="gl_template.php" class="btn btn-info"><i class="material-icons">description</i></a></td>
                        </tr> -->
                        <tr>
                          
                          <th>Products Data</th>
                          <th>Upload Institution Products data</th>
                          <td><a href="bulk_product_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                        </tr>
                        <tr>
                          
                          <th>Report Data</th>
                          <th>Upload Institution Report data</th>
                          <td><a href="bulk_report_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
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