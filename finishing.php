<?php
include("material.php");
include("functions/connect.php");

session_start();

$intname = $_SESSION["int_name"];
$intemail = $_SESSION["int_email"];
$email = $_SESSION["email"];
$fullname = $_SESSION["username"];
$codey = $_SESSION["codex"];
$name = $_SESSION["name"];
$int_id = $_SESSION["int_id"];
// finial finishing
if (isset($_POST['pass'])) {
    $conpass = $_POST["pass"];
    $_SESSION["pass"] = $conpass;
}
$extt = $_SESSION["pass"];
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $tent = password_hash($extt, PASSWORD_DEFAULT);
    // $passk = $_SESSION["password"];
    // check
    $code = $_POST['code'];
    if ($code == $codey) {
        $updatec = "UPDATE users SET users.password = '$tent' WHERE username = '$name' && int_id = '$int_id'";
        $res = mysqli_query($connection, $updatec);
        if ($res) {
            echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Password Successfully",
                text: "DONE!",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
// Unset all of the session variables
$_SESSION = array();
// Destroy the session.
session_destroy();
        $URL="login.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    } else if ($code == ""){
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Email Confirmation",
                text: "Check Email For Confirmation",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
    } else {

        function getIPAddress() {  
            //whether ip is from the share internet  
             if(!empty(empty($_SERVER['HTTP_CLIENT_IP']))) {  
                    $ip = $_SERVER['HTTP_CLIENT_IP'];  
                }  
            //whether ip is from the proxy  
            else if (!empty(empty($_SERVER['HTTP_X_FORWARDED_FOR']))) {  
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
             }  
        //whether ip is from the remote address  
            else{  
                    $ip = $_SERVER['REMOTE_ADDR'];  
             }  
             return $ip;  
        } 
        $ip = getIPAddress();
        $getip = mysqli_query($connection, "SELECT * FROM ip_blacklist WHERE ip_add = '$ip'");

        if (count([$getip]) == 1) {
            $x = mysqli_fetch_array($getip);
            $vm = $n['trial'];
            
            if ($vm >= 3) {
                $_SESSION = array();
               // Destroy the session.
               session_destroy();
               $URL="ip/block_ip.php";
               echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
            } else {
                $newcode = $vm + 1;
                $mmm = mysqli_query($connection, "UPDATE ip_blacklist SET trial = '$newcode' WHERE ip_add='$ip'");
            }
        } else {
            $try = 0;
            $timestamp = date('Y-m-d H:i:s');
            $takemeup = "INSERT INTO `ip_blacklist` (`id`, `user`, `ip_add`, `time`, `trial`) VALUES ('{$int_id}', '{$name}', '{$ip}', '{$timestamp}', '{$try}')";
            echo '<script type="text/javascript">
            $(document).ready(function(){
            swal({
                type: "error",
                title: "Wrong Confrimation Code",
                text: "Error You Will Be Blocked After Trying Three Times",
                showConfirmButton: false,
                timer: 5000
            })
        });
        </script>';
        }
    }
}
?>

<div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link active" href="#0">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $fullname; ?></h4>
    <p class="card-text">
    <!-- <a href="getkey.php?getme=<?php echo $codex ?>" target="_blank" value="button2" class="btn btn-primary btn-link btn-wd btn-sm">getcode</a> -->
    <form class="form" method="POST">
        <p class="description text-center" style="color: green;"><?php echo $mx; ?></p>
            <div class="card-body">
                <div class="form-group bmd-form-group">
                    <br>
                     <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">code</i></div>
                        </div>
                        <input type="text" name="code" placeholder="Code" class="form-control" required>
                    </div>
                </div>
                <div class="justify-content-center">
                    <button type="submit" name="button2" value="button2" class="btn btn-primary btn-link btn-wd btn-lg">SUBMIT</button>
                </div>
            </div>
    </form>
    </p>
  </div>
</div>
