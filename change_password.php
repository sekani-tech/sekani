<?php
include("material.php");
include("functions/connect.php");
require_once "bat/phpmailer/PHPMailerAutoload.php";

session_start();
?>
<?php
if (isset($_GET["edit"])) {
    $name = $_GET["edit"];
    $update = true;
    $gettheuser = mysqli_query($connection, "SELECT * FROM staff WHERE username = '$name'");

    if (count([$gettheuser]) == 1) {
        $n = mysqli_fetch_array($gettheuser);
        $vd = $n['id'];
        $int_id = $n['int_id'];
        $branch_id = $n['branch_id'];
        $fullname = $n['display_name'];
        $email = $n['email'];
        $checkupin = "SELECT * FROM institutions WHERE int_id = '$int_id'";
        $rexx = mysqli_query($connection, $checkupin);
        $ix = mysqli_fetch_array($rexx);
        $intname = $ix['int_name'];
        $intoff = $ix['office_address'];
        $intphone = $ix['office_phone'];
        $intweb = $ix['website'];
        $intemail = $ix['email'];

        $_SESSION["int_name"] = $intname;
        $_SESSION["int_email"] = $intemail;
        $_SESSION["email"] = $email;
        $_SESSION["username"] = $fullname;
        $_SESSION["name"] = $name;
        $_SESSION["int_id"] = $int_id;
    }
}
?>
<?php
$digits = 5;
$randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
$_SESSION["codex"] = $randms;
$codex = $_SESSION["codex"];
// begining of mail
$mail = new PHPMailer;
// from email addreess and name
$mail->From = $intemail;
$mail->FromName = $intname;
// to adress and name
$mail->addAddress($email, $name);
// reply address
//Address to which recipient will reply
// progressive html images
$mail->addReplyTo($intemail, "Reply");
// CC and BCC
//CC and BCC
// $mail->addCC("cc@example.com");
// $mail->addBCC("bcc@example.com");
// Send HTML or Plain Text Email
$mail->isHTML(true);
$mail->Subject = "Comfirmation Code";
$mail->Body = "Your Confirmation Code Number is: $codex";
$mail->AltBody = "This is the plain text version of the email content";
// mail system
if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} else
{
    echo $xm = "Changing Password?";
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
    <form class="form" method="POST" action="finishing.php">
        <p class="description text-center" style="color: green;"><?php echo $mx; ?></p>
            <div class="card-body">
                <script>
                    $(document).ready(function() {
                        $('#opo2').on("change keyup paste click", function () {
                            var id = $(this).val();
                            var check = $('#opo').val();
                            if (id == check) {
                                document.getElementById("mm").style.visibility = "hidden";
                            } else {
                                document.getElementById("mm").style.visibility = "visible";
                            }
                        });
                    });
                </script>
                <div class="form-group bmd-form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">lock_outline</i></div>
                        </div>
                        <input type="password" name="pass" id="opo" placeholder="Password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group bmd-form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">done_all</i></div>
                        </div>
                        <input type="password" name="confirm_pass" id="opo2" placeholder="Confirm Password" class="form-control" required>
                    </div>
                </div>
                <div class="justify-content-center">
                    <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">Change Password</button>
                </div>
            </div>
    </form>
    </p>
  </div>
</div>

<?php
// checking if IP has been Blocked
function getIPAddress() {  
  //whether ip is from the share internet  
   if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
          $ip = $_SERVER['HTTP_CLIENT_IP'];  
      }  
  //whether ip is from the proxy  
  else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
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
if (mysqli_num_rows($getip) == 1) {
  $x = mysqli_fetch_array($getip);
  $vm = $n['trial'];
  
  if ($vm >= 3) {
      $_SESSION = array();
     // Destroy the session.
     session_destroy();
     echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "IP",
                text: "THIS IP HAS BEEN BLOCKED",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
        $URL="ip/block_ip.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
  } else {
      $newcode = $vm + 1;
      $mmm = mysqli_query($connection, "UPDATE ip_blacklist SET trial = '$newcode' WHERE ip_add = '$ip'");
  }
}
?>