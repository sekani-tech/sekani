<?php
$page_title = "View Group";
$destination = "groups.php";
include('header.php');
$tableName = 'groups';
$groupBalance = "group_balance";
$groupTransactionTable = "group_transactions";
$clientTableName = 'group_clients';
$loans = "loan";

// 
function fill_client($connection)
{
    $sint_id = $_SESSION["int_id"];
    $branch_id = $_SESSION['branch_id'];
    $org = "SELECT * FROM client WHERE int_id = '$sint_id' AND branch_id = '$branch_id' ORDER BY firstname ASC";
    $res = mysqli_query($connection, $org);
    $out = '';
    while ($row = mysqli_fetch_array($res)) {
        $out .= '<option value="' . $row["id"] . '">' . $row["firstname"] . ' ' . $row["lastname"] . '</option>';
    }
    return $out;
}


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $condition = ["id" => $id];
    $output = selectOne($tableName, $condition);
    $groupID = $output['id'];


    //group balnce 
    $groupBalanceCond = ['group_id' => $groupID];
    $groupBalanceQuery = selectOne($groupBalance, $groupBalanceCond);
    //     dd($groupBalanceQuery);

    //    account officer
    // $accountOfficerCon = [
    //     'id' => $output['loan_officer'],
    //     'branch_id' => $_SESSION['branch_id']
    // ];
    // $accountOfficer = selectOne('staff', $accountOfficerCon);
    // dd($accountOfficer);

    // //group transaction 
    $groupTransactionCond = ['group_id' => $groupID];
    $Withdrawal = ['transaction_type' => 'withdrawal'];
    $deposit = ['transaction_type' => 'deposit'];
    $groupTransactQuery = selectAll($groupTransactionTable, $groupTransactionCond);
    if (!$groupTransactQuery) {
        $groupTransactDep = '0000-00-00';
        $groupTransactWit = '0000-00-00';
    }
    //     dd($groupTransactQuery);

    $groupName = $output['g_name'];
    $clientCondition = ['group_name' => $groupName];
    $groupMembers = selectAll($clientTableName, $clientCondition);

    //    getting Loan Total
    $loanTotal = [];
    foreach ($groupMembers as $key => $lonaVal) {
        $customersID = $lonaVal['client_id'];
        $loanCond = ['client_id' => $customersID];
        $loansCheck = selectAll($loans, $loanCond);
        foreach ($loansCheck as $loan) {
            $loanTotal[] = $loan['principal_amount'];
        }
    }
}

if (isset($_POST['add-member'])) {
    //    dd($_POST);
    $sint_id = $_SESSION['int_id'];
    $branch_id = $_SESSION['branch_id'];

    //    dd($data);
    $clientCondition = [
        'id' => $_POST['client_id'],
        'branch_id' => $branch_id
    ];
    $clientDetails = selectOne('client', $clientCondition);
    //    dd($clientDetails);
    $data = [
        'int_id' => $sint_id,
        'group_name' => $_POST['group_name'],
        'branch_id' => $branch_id,
        'client_id' => $_POST['client_id'],
        'client_name' => $clientDetails['display_name'],
        'account_no' => $clientDetails['account_no'],
        'mobile_no' => $clientDetails['mobile_no'],
        'group_id' => $_POST['group_id']
    ];
    //    dd($data);
    $existingUserCon = [
        'client_id' => $data['client_id'],
        'branch_id' => $branch_id,
        'group_name' => $data['group_name']
    ];
    $existingUser = selectOne('group_clients', $existingUserCon);
    if (!$existingUser) {
        $result = create('group_clients', $data);
        header("refresh: 2");
    } else {
        echo "User Already exist in this Group";
    }
}
?>

<div class="content">
    <div class="container-fluid">
        <!-- your content here -->

        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Group Account Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Group Name:</label>
                            <input type="text" id="" style="text-transform: uppercase;" class="form-control" value="<?php echo $output['g_name'] ?>" readonly name="display_name">
                        </div>
                        <div class="row">

                            <div class="col-md-6">


                                <div class="form-group">
                                    <label for="">Account Number:</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $output['account_no'] ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account Officer:</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php
                                                                                                                                    $loanOfficer = $output['loan_officer'];
                                                                                                                                    // Find loan officers name from staff table
                                                                                                                                    $query_staff = mysqli_query($connection, "SELECT * FROM `staff` WHERE id = '$loanOfficer' AND int_id = '$sessint_id'");
                                                                                                                                    if (mysqli_num_rows($query_staff) > 0) {
                                                                                                                                        $ms = mysqli_fetch_array($query_staff);
                                                                                                                                        $staff_fullname = strtoupper($ms["display_name"]);
                                                                                                                                    }
                                                                                                                                    echo $staff_fullname;

                                                                                                                                    ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Outstanding Loan:</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo array_sum($loanTotal) ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Group purse Balance</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $groupBalanceQuery['account_balance_derived']; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Available Balance:</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $groupBalanceQuery['account_balance_derived']; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Last Deposit:</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $groupTransactDep ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Last Withdrawal:</label>
                                    <input type="text" name="" style="text-transform: uppercase;" id="" class="form-control" value="<?php echo $groupTransactWit ?>" readonly>
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
                                                <table class="rtable display nowrap text-center" style="width:100%">
                                                    <thead class=" text-primary">

                                                        <th>SN</th>
                                                        <th>Full Name</th>
                                                        <th>Account Type</th>
                                                        <th>Account Number</th>
                                                        <th>View</th>

                                                        <!-- <th>Phone</th> -->
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($groupMembers as $key => $groupMember) { ?>
                                                            <tr>
                                                                <th class="text-left"><?php echo $key + 1 ?></th>
                                                                <th class="text-left"><?php echo $groupMember['client_name'] ?></th>
                                                                <th class="text-left"><?php
                                                                    $actype = $groupMember['product_id'];
                                                                    $spn = mysqli_query($connection, "SELECT * FROM savings_product WHERE id = '$actype' AND int_id = '$sessint_id'");
                                                                    if (mysqli_num_rows($spn) > 0) {
                                                                        $ms = mysqli_fetch_array($spn);
                                                                        $product_name = strtoupper($ms["name"]);
                                                                    }
                                                                    echo $product_name;
                                                                    ?></th>
                                                                <th class="text-left"><?php echo "00" . $groupMember['account_no'] ?></th>
                                                                <td>
                                                                    <a href="client_view.php?edit=<?php echo $groupMember['client_id']; ?>" class="btn btn-info">View</a>
                                                                </td>
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
                                    <a href="update_group.php?edit=<?php echo $id; ?>" class="btn btn-primary">Edit
                                        Group Details</a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong"> Add Member
                                    </button>
                                    <a href="manage_client.php" class="btn btn-primary">Create Member</a>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <div class="col-md-12">
                                                    <form action="" method="POST">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="material-icons">person</i>
                                                                </span>
                                                            </div>
                                                            <select name="client_id" id="client_id" class="form-control" required>
                                                                <option hidden value="">select a Client</option>
                                                                <?php echo fill_client($connection); ?>
                                                            </select>
                                                            <input type="text" hidden name="group_id" value="<?php echo $_GET['edit'] ?>">
                                                            <input type="text" hidden name="group_name" value="<?php echo $output['g_name'] ?>">

                                                            <button type="submit" name="add-member" class="btn btn-primary p-2">Add Member
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">
                                                    <table class="table text-center">
                                                        <thead>

                                                            <tr>
                                                                <th>S/N</th>
                                                                <th>Full Name</th>
                                                                <th>Account Number</th>
                                                                <th>Remove</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($groupMembers as $key => $groupMember) { ?>
                                                                <tr>
                                                                    <td class="text-center"><?php echo $key + 1 ?></td>
                                                                    <td><?php echo $groupMember['client_name'] ?></td>
                                                                    <td><?php echo "00" . $groupMember['account_no'] ?></td>
                                                                    <td class="text-center">
                                                                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round">
                                                                            <i class="material-icons">close</i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                                </button>

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