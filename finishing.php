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
$passk = $_SESSION["password"];
// finial finishing
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION["password"] = $_POST['pass'];
}
echo $passk;
?>
<?php
if(isset($_POST["button2"])){
    $code = $_POST['code'];
    // pronlem
    $hash = $passk;
    if ($code == $codey) {
        $updatec = "UPDATE users SET password = '$hash' WHERE username = '$name' && int_id = '$int_id'";
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
