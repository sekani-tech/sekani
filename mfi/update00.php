<?php
include '../functions/connect.php';

$data = selectSpecificData('account', ['id', 'account_no']);

array_walk_recursive($data, function (&$v, $k) {
    if ($k === 'account_no') {
        if (strlen($v) > 8) {
            $v = $v;
        } else {
            $v = "00" . $v;
        }
    }
});

// sending data back to database
foreach ($data as $key => $value) {
    $result = update('account', $value['id'], 'id', ['account_no' => $value['account_no']]);
}
echo "Update Successfully";