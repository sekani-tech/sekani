<?php

$page_title = "Bulk Product Data";
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
               <h4 class="card-title ">Bulk Product Data</h4>
           
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
                       
                       <th>Fixed Deposit</th>
                       <th>Upload Institution Fixed Deposit data</th>
                       <td><a href="bulk_product_fixed_deposit_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                     </tr>
                     <tr>
                       
                       <th>Loan</th>
                       <th>Upload Institution Product Loan data</th>
                       <td><a href="bulk_product_loan_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
                     </tr>
                     <tr>
                       
                       <th>Savings</th>
                       <th>Upload Institution Product Savings data</th>
                       <td><a href="bulk_product_savings_data.php" class="btn btn-info"><i class="material-icons" style="margin: auto;">description</i></a></td>
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