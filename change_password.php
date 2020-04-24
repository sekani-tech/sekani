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
        $digits = 5;
        $randms = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        $_SESSION["codex"] = $randms;
    }
}
?>
<?php
$codex = $_SESSION["codex"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    // a passowrd
    $pass = $_POST['pass'];
    $con_pass = $_POST['confirm_pass'];
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    if ($code == $codex && $pass == $con_pass) {
        $updatec = "UPDATE users SET password = '$hash' WHERE username = '$username' && int_id = '$int_id'";
        $res = mysqli_query($connection, $updatec);
        if ($res) {
            echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "success",
                title: "Created Password Successfully",
                text: "Wrong Confrimation Code",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
        $URL="login.php";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
        }
    } else {
        echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "error",
                title: "Error",
                text: "Wrong Confrimation Code or Password",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
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
    <form class="form" method="POST">
        <p class="description text-center" style="color: green;">check your mail for confirmation code</p>
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
                        <div style="color:red;" id="mm" hidden>The Inputed Pasword Doesn't Match</div>
                    </div>
                </div>
                <div class="form-group bmd-form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">code</i></div>
                        </div>
                        <input type="number" name="code" placeholder="Code" class="form-control" required>
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
    echo "Confirmation code has been sent, has been sent successfully";
}
// end of mail
?>