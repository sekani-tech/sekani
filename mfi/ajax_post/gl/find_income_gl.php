<?php
include("../../../functions/connect.php");
$output = '';
?>
<?php
if (isset($_POST["id"]))
{
    if ($_POST["id"] != '')
    {
      $gl_code = $_POST['id'];
      $int_id = $_POST['ist'];
      $out = '';
      function fill_acct($connection, $gl_code, $int_id, $out) {
        $sql = "SELECT * FROM `acc_gl_account` WHERE gl_code LIKE '$gl_code%' && int_id='$int_id' &&	disabled = '0' && manual_journal_entries_allowed = '1' && parent_id IS NOT NULL";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result))
          {
            $out .= '<option value="'.$row["gl_code"].'">'.strtoupper($row["name"]).'</option>';
          }
        return $out;
      }
      // hello
      $output = '<div class="form-group">
      <label>Account Name:</label>
      <select class="form-control" name="gl_no" class="form-control" id="" readonly>
        "'.fill_acct($connection, $gl_code, $int_id, $out).'"
      </select>
    </div>';
      echo $output;
  }
}
?>