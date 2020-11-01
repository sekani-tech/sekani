<?php
include('../path.php');
$page_title = "View Group";
$destination = "groups.php";
// get connections for all pages
include(ROOT_PATH . "/functions/DbModel/db.php");
include('header.php');
//$int_id = $_SESSION['int_id'];
$tableName = 'groups';
$groupBalance = "group_balance";
$groupTransactionTable = "group_transactions";
$clientTableName = 'group_clients';
$loans = "loan";
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $condition = ["id" => $id];
    $output = selectOne($tableName, $condition);
    $groupID  =  $output['id'];
   
    //group balnce 
    $groupBalanceCond = ['group_id' => $groupID];
    $groupBalanceQuery = selectOne($groupBalance,$groupBalanceCond);

    //group transaction 
    $groupTransactionCond = ['group_id' => $groupID];    // $Withdrawal = ['transaction_type' => 'withdrawal'];
    // $deposit = ['transaction_type' => 'deposit'];
    $groupTransactQuery = selectAll($groupBalance,$groupTransactionCond);

    $groupName = $output['g_name'];
    $clientCondition = ['group_name' => $groupName];
    $groupMembers = selectAll($clientTableName, $clientCondition);
   // dd($output);
}
?>
  
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->

            <div class="row">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Group Account Deatils</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group">

                                <label for="">Group Name:</label>
                                <input type="text" name="" id="" style="text-transform: uppercase;" class="form-control"
                                       value="" readonly name="display_name">
                            </div>
                            <div class="row">

                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="">Account Number:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value=""
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Account Officer:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value=""
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Account Type:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value=""
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Outstanding Loan:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Group puce Balance</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Avaliable Balance:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Last Deposit:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Last Withdrawal:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="" readonly>
                                    </div>
                                </div>

                             <div class="row">


                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Group Members</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="rtable display nowrap" style="width:100%">
                                                    <thead class=" text-primary">

                                                    <th>SN</th>
                                                    <th>
                                                        First Name
                                                    </th>

                                                    <th>
                                                        Account Type
                                                    </th>
                                                    <th>
                                                        Account Number
                                                    </th>
                                                    <th>View</th>

                                                    <!-- <th>Phone</th> -->
                                                    </thead>
                                                    <tbody>
                                                    
                                                        <tr>

                                                            <th class="text-center"></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <td><a href="" class="btn btn-info">View</a></td>

                                                        </tr>
                                                     
                                                    <!-- <th></th> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>


                                </div>


                                <div class="col-md-6">
                                    <a href="update_group.php?edit=<?php echo $id;?>" class="btn btn-primary">Edit Group Details</a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                                            Add New Member
                                            </button>

                                </div>

                                                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                   
                                    <div class="col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="material-icons">person</i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Enter New Member Account Number">
                                    </div>
                               
                                </div>
                                    </div>
                                    <div class="modal-body">
                                     
                                <div class="row">
                                <table class="table">
                                <thead>

                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Full Name</th>
                                        <th>Account Number</th>
                                        <th class="text-center">Remove</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    <tr>
                                    <td class="text-center">1</td>
                                        <td>Andrew Mike</td>
                                        <td>123456789</td>
                                        <td class="text-center"><button class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                        <i class="material-icons">close</i>
                                        </button></td>
                                    </tr>
                                
                                </tbody>
                            </table>
                                </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Add Member</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!--End of Modal -->

                                </div>
                            </div>

                        </div>
                    </div>

                </div>


            </div>


        </div>


    </div>
  

<?php

include('footer.php');

?>