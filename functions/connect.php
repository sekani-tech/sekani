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
    $stmt = $connection->prepare($sql);
    if (!empty($data)) {
        $values = array_values($data);
        $types = str_repeat('s', count($values));
        $stmt->bind_param($types, ...$values);
    }
    $stmt->execute();
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
 * @param $table
 * @param $conditions
 * @return array|null
 */
function selectOneWithOrder($table, $conditions, $orderCondition, $orderType, $limitNumber)
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
    return $stmt->get_result()->fetch_assoc();
}


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