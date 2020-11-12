<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no pssword) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'sekanisy');
define('DB_PASSWORD', '4r6WY#JP+rnl67');
define('DB_CHARSET', 'utf8');
define('DB_NAME', 'sekanisy_admin');
// connect to the database with the defined values
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// if there's an error
if (!$connection) {
    echo "Failed to connect database" . die(mysqli_error($connection));;
}
$dbselect = mysqli_select_db($connection, DB_NAME);
if (!$dbselect) {
    echo "Failed to Select database" . die(mysqli_error($connection));
}

//session_start();

function dd($value)
{ // to be deleted
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

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

function update($table, $id, $conName, $data)
{
    global $connection;
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

function delete($table, $id)
{
    global $connection;
    $sql = "DELETE FROM $table WHERE " . $id . "=?";


    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
}

function countRecords($table)
{
    global $connection;
    $sql = "SELECT COUNT(*) AS count FROM $table";
    $stmt = executeQuery($sql);
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'];
}

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

