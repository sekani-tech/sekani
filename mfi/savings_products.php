<?php

$page_title = "Clients";
$destination = "index.php";
    include("header.php");

?>
<?php
// //  Sweet alert Function

// // If it is successfull, It will show this message
//   if (isset($_GET["message1"])) {
//     $key = $_GET["message1"];
//     $tt = 0;
//   if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
//     // $out = $_SESSION["lack_of_intfund_$key"];
//     echo '<script type="text/javascript">
//     $(document).ready(function(){
//         swal({
//             type: "success",
//             title: "Registration Successful",
//             text: "Awaiting Approval of New client",
//             showConfirmButton: false,
//             timer: 2000
//         })
//     });
//     </script>
//     ';
//     $_SESSION["lack_of_intfund_$key"] = 0;
//   }
// }
// // If it is not successfull, It will show this message
// else if (isset($_GET["message2"])) {
//   $key = $_GET["message2"];
//   $tt = 0;
//   if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
//   // $out = $_SESSION["lack_of_intfund_$key"];
//   echo '<script type="text/javascript">
//   $(document).ready(function(){
//       swal({
//           type: "error",
//           title: "Error",
//           text: "Error during Registration",
//           showConfirmButton: false,
//           timer: 2000
//       })
//   });
//   </script>
//   ';
//   $_SESSION["lack_of_intfund_$key"] = 0;
// }
// }
// if (isset($_GET["message3"])) {
//   $key = $_GET["message3"];
//   // $out = $_SESSION["lack_of_intfund_$key"];
//   $tt = 0;
//   if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
//   echo '<script type="text/javascript">
//   $(document).ready(function(){
//       swal({
//           type: "success",
//           title: "Success",
//           text: "Client was Updated successfully!",
//           showConfirmButton: false,
//           timer: 2000
//       })
//   });
//   </script>
//   ';
//   $_SESSION["lack_of_intfund_$key"] = 0;
// }
// }
// else if (isset($_GET["message4"])) {
// $key = $_GET["message4"];
// // $out = $_SESSION["lack_of_intfund_$key"];
// $tt = 0;
//   if ($tt !== $_SESSION["lack_of_intfund_$key"]) {
// echo '<script type="text/javascript">
// $(document).ready(function(){
//     swal({
//         type: "error",
//         title: "Error",
//         text: "Error updating client!",
//         showConfirmButton: false,
//         timer: 2000
//     })
// });
// </script>
// ';
// $_SESSION["lack_of_intfund_$key"] = 0;
//   }
// }
?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Savings Products</h4>
                  <script>
                  $(document).ready(function() {
                  $('#tabledat').DataTable();
                  });
                  </script>
                  <!-- Insert number users institutions -->
                  <p class="card-category">
                   <a class="btn btn-primary" href="create_savings_product.php">Create Savings Products</a>
                   <a href="create_deposit_product.php" class="btn btn-primary">Create Fixed Term Deposit Saving Product</a>
                   <a href="#" class="btn btn-primary">Copy Existing Savings/Fixed Term Deposit Savings Product</a>
                </p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="tabledat" class="table" cellspacing="0" style="width:100%">
                      <thead class=" text-primary">
                        <th>Name</th>
                        <th>Description</th>
                        <th>Product Group</th>
                        <th>Type</th>
                        <th></th>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><a href="" class="btn btn-info">Edit</a></td>
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