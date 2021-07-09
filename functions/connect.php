<?php
include "DbModel/db.php";

//session_start();

function dd($value)
{ // to be deleted
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

/**
 * @param $value
 */
function ddA($value)
{ // to be deleted
    echo "<pre>", print_r($value, true), "</pre>";
}

/**
 * @param $sql
 * @param array $data
 * @return false|mysqli_stmt
 */
function executeQuery($sql, $data = [])
{
    global $connection;
    if($stmt = $connection->prepare($sql)){
        if (!empty($data)) {
            $values = array_values($data);
            $types = str_repeat('s', count($values));
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
    }else{
        $stmt = var_dump($connection->error);
    }
    return $stmt;
}
function executeQuery2($sql, $data = [])
{
    global $connection;
    if($stmt = $connection->prepare($sql)){
        if (!empty($data)) {
            $values = array_values($data);
            $types = str_repeat('s', count($values)+1);
            $stmt->bind_param($types, ...$values);
        }
        $stmt->execute();
    }else{
        $stmt = var_dump($connection->error);
    }
    return $stmt;
}

/**
 * @param $table
 * @param array $conditions
 * @return mixed
 */
function selectAll($table, $conditions = [])
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


/**
 * @param $table
 * @param array $conditions
 * @return mixed
 */
function selectAllWithOr($table, $conditions = [], $orField, $orValue)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $sql = $sql . " OR " . $orField . "=" . $orValue;

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectOne($table, $conditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";

    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_assoc();
}
/**
 * 
 * 
 


 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectOneOrderByDescLimit($table, $column, $order_data)
{
    global $connection;
    $sql = "SELECT $column FROM $table";

    $sql = $sql . " ORDER BY $order_data DESC LIMIT 1";

    $stmt = executeQuery($sql);
    return $stmt->get_result()->fetch_assoc();
}

function selectOneByIntID($table, $column, $search_parameter)
{
    global $connection;
    $sql = "SELECT $column FROM $table";

    $sql = $sql . " WHERE int_id = $search_parameter";

    $stmt = executeQuery($sql);
    return $stmt->get_result()->fetch_assoc();
}
/**




/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectAllWithOrder($table, $conditions, $orderCondition, $orderType)
{
    $orderType = strtoupper($orderType);
    $table = strtolower($table);
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " ORDER BY $orderCondition $orderType";
    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


/**
 * @param $table
 * @param $pickConditions
 * @param array $conditions
 * @return array|mixed|null
 */
function selectSpecificData($table, $pickConditions, $conditions = [])
{
    global $connection;
    $sql = "SELECT";
    $increamental = 0;
    foreach ($pickConditions as $value) {
        if ($increamental === 0) {
            $sql = $sql . " $value";
        } else {
            $sql = $sql . ", $value";
        }
        $increamental++;
    }
    $sql = $sql . " FROM $table";

    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
    }

    $sql = $sql . " LIMIT 1";

    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_assoc();
}




/**
 * @param $table
 * @param $pickConditions
 * @param array $conditions
 * @return array|mixed|null
 */
function selectAllSpecificData($table, $pickConditions, $conditions = [])
{
    global $connection;
    $sql = "SELECT";
    $increamental = 0;
    foreach ($pickConditions as $value) {
        if ($increamental === 0) {
            $sql = $sql . " $value";
        } else {
            $sql = $sql . ", $value";
        }
        $increamental++;
    }
    $sql = $sql . " FROM $table";

    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
    }

    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param $table
 * @param $conditions
 * @return array|null
 */
function checkLoanArrears($table, $conditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " AND installment >= '1' ORDER BY id ASC LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    return $stmt->get_result()->fetch_assoc();
}

/**
 * @param $table
 * @param $data
 * @return int
 */
function create($table, $data)
{
    global $connection;
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

/**
 * @param $table
 * @param $id
 * @param $conName
 * @param $data
 * @return int
 */
function update($table, $id, $conName, $data)
{
    $sql = "UPDATE $table SET ";
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }

    $sql = $sql . " WHERE " . $conName . "=?";
    $data[$conName] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}

/**
 * @param $table
 * @param $id
 * @return int
 */
function delete($table, $id, $consName)
{
    $sql = "DELETE FROM $table WHERE " . $consName . "=?";
    $stmt = executeQuery($sql, [$consName => $id]);
    return $stmt->affected_rows;
}

/**
 * @param $table
 * @return mixed
 */
function countRecords($table)
{
    global $connection;
    $sql = "SELECT COUNT(*) AS count FROM $table";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'];
}

/**
 * @param $table1
 * @param $int_id
 * @param $branch_id
 * @param $term
 * @return mixed
 */
function searchClient($table1, $int_id, $branch_id, $term)
{
    $match = '%' . $term . '%';
    global $connection;
    $sql = "SELECT c.* 
            FROM $table1 AS c 
            WHERE c.int_id=?
            AND c.branch_id=? AND (c.firstname LIKE ? OR c.lastname LIKE ? OR c.display_name LIKE ?)";

//    dd($sql);
    $stmt = executeQuery($sql, [
        'int_id' => $int_id,
        'branch_id' => $branch_id,
        'firstname' => $match,
        'lastname' => $match,
        'display_name' => $match
    ]);
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * @param $table1
 * @param $int_id
 * @param $term
 * @return mixed
 */
function searchGroup($table1, $int_id, $term)
{
    $match = '%' . $term . '%';
    global $connection;
    $sql = "SELECT g.* 
            FROM $table1 AS g 
            WHERE g.int_id=? AND g.g_name LIKE ?";

//    dd($sql);
    $stmt = executeQuery($sql, [
        'int_id' => $int_id,
        'g_name' => $match
    ]);
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// function to insert a new row into an arbitrary table, with the columns filled with the values 
// from an associative array and completely SQL-injection safe

function insert($table, $record) {
    global $connection;
    $cols = array();
    $vals = array();
    foreach (array_keys($record) as $col) $cols[] = sprintf("`%s`", $col);
    foreach (array_values($record) as $val) $vals[] = sprintf("'%s'", mysqli_real_escape_string($connection, $val));

    mysqli_query($connection, sprintf("INSERT INTO `%s`(%s) VALUES(%s)", $table, implode(", ", $cols), implode(", ", $vals)));

    return mysqli_insert_id($connection);
}

// date functions to find individual components of date 
// and add or subtract from date
function getYear($date){
    $date = DateTime::createFromFormat("Y-m-d", $date);
    return $date->format("Y");
}

function getMonth($date){
    $date = DateTime::createFromFormat("Y-m-d", $date);
    return $date->format("m");
}

function getDay($date){
    $date = DateTime::createFromFormat("Y-m-d", $date);
    return $date->format("d");
}

function addYear($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period year"));
    return $valueDate;
}

function addMonth($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period month"));
    return $valueDate;
}

function addWeek($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period week"));
    return $valueDate;
}

function addDay($date, $period){
    $valueDate = date("Y-m-d", strtotime($date. "+$period day"));
    return $valueDate;
}

function appendAccountNo($accountNo, $length){
    $appendedAccount = '******'.substr($accountNo, $length);
    return $appendedAccount;
}

// select data that is equal  and less than
function checkLoanDebtor($table, $conditions, $dateConditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $s = 0;
    foreach ($dateConditions as $keys => $value) {
        if ($s === 0) {
            $sql = $sql . " AND ( $keys<=?";
        }else{
            $sql = $sql . " AND $keys<=?";
        }
        $s++;
    }
    $sql = $sql. ")";
    $sql = $sql . " AND installment >= '1' ORDER BY id ASC LIMIT 1";
    $stmt = executeQuery($sql, array_merge($conditions, $dateConditions));
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function selectAllGreater($table, $conditions = [])
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key>=?";
            } else {
                $sql = $sql . " AND $key>=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

function selectAllLess($table, $conditions = [])
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key>=?";
            } else {
                $sql = $sql . " AND $key<=?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


function selectAllLessEq($table, $conditions, $dateConditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $s = 0;
    foreach ($dateConditions as $keys => $value) {
        if ($s === 0) {
            $sql = $sql . " AND $keys<=?";
        }else{
            $sql = $sql . " AND $keys<=?";
        }
        $s++;
    }
    $stmt = executeQuery($sql, array_merge($conditions, $dateConditions));
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function checkAccount($table, $conditions, $scaleConditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    # CHECK CUSTOMERS ACCOUNT BALANCE
    # IF VALUE IS GREATER THAN ZERO
    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $s = 0;
    foreach ($scaleConditions as $key => $value) {
        if ($s === 0) {
            $sql = $sql . " AND $key>=?";
        } 
        $s++;
    }

    $stmt = executeQuery($sql, array_merge($conditions, $scaleConditions));
    return $stmt->get_result()->fetch_assoc();
}

// find out values that do not exist on tables
function findNotIn($table, $conditions, $notIn, $table2, $sort, $conditions2)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " AND $notIn NOT IN (";
    $sql = $sql . "SELECT $sort FROM $table2";
    $s = 0;
    foreach ($conditions2 as $key => $value) {
        if ($s === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $s++;
    }
    $sql = $sql . ")";
    $stmt = executeQuery2($sql, array_merge($conditions, $conditions2));
    return $stmt->get_result()->fetch_assoc();
}


// find out values that exist on tables
function findIn($table, $conditions, $notIn, $table2, $sort, $conditions2)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " AND $notIn IN(";
    $sql = $sql . "SELECT $sort FROM $table2";
    $s = 0;
    foreach ($conditions2 as $key => $value) {
        if ($s === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $s++;
    }
    $sql = $sql . ")";
    $stmt = executeQuery2($sql, array_merge($conditions, $conditions2));
    return $stmt->get_result()->fetch_assoc();
}


function sumNotIn($sum, $table, $conditions, $notIn, $table2, $sort, $conditions2)
{
    global $connection;
    $sql = "SELECT SUM($sum) FROM $table";
    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " AND $notIn NOT IN(";
    $sql = $sql . "SELECT $sort FROM $table2";
    $s = 0;
    foreach ($conditions2 as $key => $value) {
        if ($s === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $s++;
    }
    $sql = $sql . ")";
    $stmt = executeQuery2($sql, array_merge($conditions, $conditions2));
    return $stmt->get_result()->fetch_assoc();
}

function sumIn($sum, $table, $conditions, $notIn, $table2, $sort, $conditions2)
{
    global $connection;
    $sql = "SELECT SUM($sum) FROM $table";
    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }

    $sql = $sql . " AND $notIn IN(";
    $sql = $sql . "SELECT $sort FROM $table2";
    $s = 0;
    foreach ($conditions2 as $key => $value) {
        if ($s === 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $s++;
    }
    $sql = $sql . ")";
    $stmt = executeQuery2($sql, array_merge($conditions, $conditions2));
    return $stmt->get_result()->fetch_assoc();
}

function selectAllandNot($table, $conditions = [], $notConditions)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $sql = $sql . " AND (";
        $s = 0;
        foreach ($notConditions as $key => $value) {
            if ($s === 0) {
                $sql = $sql . " $key!=?";
            } else {
                $sql = $sql . " AND $key!=?";
            }
            $s++;
        }
        $sql = $sql . " )";
        $stmt = executeQuery($sql, array_merge($conditions, $notConditions));
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}


function selectOneWithOr($table, $conditions = [], $orField, $orValue)
{
    global $connection;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }

        $sql = $sql . " OR " . $orField . "=" . $orValue;

        $stmt = executeQuery($sql, $conditions);
        return $stmt->get_result()->fetch_assoc();;
    }

    function getCharges($connection) {
        $sint_id = $_SESSION["int_id"];
        $org = "SELECT * FROM charge WHERE int_id = '$sint_id'";
        $res = mysqli_query($connection, $org);
        $out = [];
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $out[$i] = $row['id'];
            $i++;
        }
        return $out;
    }
    
    function getClients($connection) {
        $sint_id = $_SESSION["int_id"];
        $branc = $_SESSION["branch_id"];
        $org = "SELECT client.id, client.firstname, client.lastname, client.middlename FROM client JOIN branch ON client.branch_id = branch.id WHERE client.int_id = '$sint_id' AND (branch.id = '$branc' OR branch.parent_id = '$branc') AND status = 'Approved' ORDER BY firstname ASC";
        $res = mysqli_query($connection, $org);
        $out = [];
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $out[$i] = $row['id'];
            $i++;
        }
        return $out;
    }
    
    function getAccNumbers($connection, $client_id) {
        $pen = "SELECT * FROM account WHERE client_id = '$client_id'";
        $res = mysqli_query($connection, $pen);
        $out = [];
        $i = 0;
        while ($row = mysqli_fetch_array($res))
        {
            $out[$i] = $row['account_no'];
            $i++;
        }
        return $out;
    }
    
function getMonthName($monthNum) {
    $dateObj = DateTime::createFromFormat('!m', $monthNum);
    return $dateObj->format('F');
}

function endOfMonth($closedDate,$connection,$_cb) {
    $month = getMonthName((int)getMonth($closedDate));
    $year = getYear($closedDate);

    $data = [
        'int_id' => $_SESSION['int_id'],
        'branch_id' => $_SESSION['branch_id'],
        'staff_id' => $_SESSION['staff_id'],
        'manual_posted' => 1,
        'closed_date' => $closedDate,
        'month' => $month,
        'year' => $year
    ];

    $existingClosedMonth = selectAll('endofmonth_tb', ['month'=>$month,'year'=>$year,'int_id'=>$_SESSION['int_id']]);

    $arr = array(
        'connection'=>$connection,
        'data'=>$data
    );

    if(count($existingClosedMonth) > 0) {
        call_user_func($_cb,'End of Month already exists!',1);
        exit();
    } else {

        $existingClosedDay = selectAll('endofday_tb', ['transaction_date'=>$closedDate,'int_id'=>$_SESSION['int_id']]);

        // if(count($existingClosedDay) < 1) {
            // $digits = 7;
            // $randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

            // $_SESSION['feedback'] = "Please perform the end of day for {$month}, {$year}";
            // header("Location: ../../mfi/end_of_day.php?message1=$randms");

        // } else {
            include('../asset_depreciation.php');
            include('../charge_collection.php');
            include("../loans/auto_function/loan_collection.php");
            asset_depreciation($arr, $_cb, function($_cb,$arr){
                if($arr['response']==0) {
                    charge_collection($arr, $_cb, function($_cb,$arr){
                        if($arr['response']==0) {
                                insert('endofmonth_tb',$arr['data']);
                                loan_collection($arr['connection']);
                                call_user_func($_cb,"Asset Depreciation Successful, Charge Collection Successful, Loan Collection Successful, Month sucessfully ended", 0);
                                exit();
                        } else {
                            call_user_func($_cb,"{$arr['response']}!",1);
                            exit();
                        }       
                    });
                } else {
                    call_user_func($_cb,"{$arr['response']}!",1);
                    exit();
                }
            });
        // }
       
    }
    
}
}
//function to run eod
function eod($date_data){
    $int_id = $_SESSION['int_id'];
    $eod_stored = selectOneOrderByDescLimit('endofday_tb','transaction_date','id',$int_id)['transaction_date'];
    $eod_stored = date("Y-m-d", strtotime($eod_stored));
    $eod_day = getDay($eod_stored);
    $data_day = getDay($date_data);

    if ($data_day == $eod_day){
        $eod_check = 2;
    }else if ($data_day > $eod_day){
        $eod_check = 1;
    }else if ($data_day < $eod_day){
        $eod_check = 0;
    }
    return $eod_check;
}

