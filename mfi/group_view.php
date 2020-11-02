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
    $groupBalanceQuery = selectAll($groupBalance,$groupBalanceCond);

    //group transaction 
    $groupTransactionCond = ['group_id' => $groupID];
    // $Withdrawal = ['transaction_type' => 'withdrawal'];
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
                                       value="<?php echo $output['g_name'] ?>" readonly name="display_name">
                            </div>
                            <div class="row">

                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label for="">Account Number:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php echo $output['account_no'] ?>"
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Account Officer:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php echo $output['loan_officer'] ?>"
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Account Type:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php echo $output['account_type'] ?>"
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Outstanding Loan:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php
                                                        foreach ($groupMembers as $key => $lonaval) {
                                                                $customersID = $lonaval['client_id'];
                                                                $loanCond = ['client_id' => $customersID]; 
                                                                $loansCheck = selectAll($loans, $loanCond);
                                                                foreach ($loansCheck as $loan) {
                                                                    echo $loan['principal_amount'];
                                                                }
                                                        }
                                               ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Group puce Balance</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php echo  $groupBalanceQuery['account_balance_derived']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Avaliable Balance:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php echo $groupBalanceQuery['account_balance_derived']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Last Deposit:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php 
                                                    if ($groupTransactQuery['transaction_type'] == 'deposit') {
                                                        echo $groupBalanceQuery['transaction_date'];
                                                    }
                                               ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Last Withdrawal:</label>
                                        <input type="text" name="" style="text-transform: uppercase;" id=""
                                               class="form-control" value="<?php 
                                                            if ($groupTransactQuery['transaction_type'] == 'withdrawal') {
                                                                echo $groupBalanceQuery['transaction_date'];
                                                            }
                                                ?>" readonly>
                                    </div>
                                </div>

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
                                                    <?php foreach ($groupMembers as $key => $groupMember) { ?>
                                                        <tr>

                                                            <th class="text-center"><?php echo $key+1 ?></th>
                                                            <th><?php echo $groupMember['client_name'] ?></th>
                                                            <th><?php // echo $groupMember[''] ?></th>
                                                            <th><?php echo $groupMember['account_no'] ?></th>
                                                            <td><a href="" class="btn btn-info">View</a></td>

                                                        </tr>
                                                    <?php } ?>
                                                    <!-- <th></th> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                    </div>


                                </div>

                                <div class="col-md-6">
                                    <a href="" class="btn btn-primary">Edit Group</a>
                                    <a href="" class="btn btn-primary">Add Member to Group</a>
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