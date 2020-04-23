<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if($_SESSION["usertype"] == "super_admin"){
    header("location: index.php");
    exit;
  } 
  elseif($_SESSION["usertype"] == "admin"){
    header("location: ./modules/admin/dashboard.php");
    exit;
  }
//   elseif($_SESSION["usertype"] == "staff"){
//       if($_SESSION["employee_status"] == "Employed"){
//         header("location: mfi/index.php");
//       }
//       elseif($_SESSION["employee_status"] == "Decommisioned"){
//         $err = "Sorry, you are not allowed to login";
//         $password = "";
//       }
//     exit;
//   }
}
 
// Include config file
require_once "functions/config.php";
require_once "bat/phpmailer/PHPMailerAutoload.php";
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT users.id, staff.user_id, users.int_id, users.branch_id, staff.email, users.username, users.fullname, users.usertype,staff.employee_status, users.password, org_role, display_name FROM staff JOIN users ON users.id = staff.user_id WHERE users.username = ?";
        // $sqlj = "SELECT users.id, users.int_id, users.username, users.fullname, users.usertype, users.password, org_role, display_name FROM staff JOIN users ON users.id = staff.user_id WHERE users.username = "sam"";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $user_id, $int_id, $branch_id, $email, $username, $fullname, $usertype, $employee_status, $hashed_password, $org_role, $display_name);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            session_regenerate_id();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["int_id"] = $int_id;
                            $_SESSION["email"] = $email;
                            $_SESSION["username"] = $username;
                            $_SESSION["usertype"] = $usertype;
                            $_SESSION["fullname"] = $fullname;
                            $_SESSION["org_role"] = $org_role;
                            $_SESSION["employee_status"] = $employee_status;
                            $_SESSION["branch_id"] = $branch_id;
                            // $_SESSION["lastname"] = $lastname;
                            // begining of mail
                            $mail = new PHPMailer;
                            // from email addreess and name
                            $mail->From = "techsupport@sekanisystems.com.ng";
                            $mail->FromName = "Sekani Systems";
                            // to adress and name
                            $mail->addAddress($email, $username);
                            // reply address
                            //Address to which recipient will reply
                            $mail->addReplyTo("techsupport@sekanisystems.com.ng", "Reply");
                            // CC and BCC
                            //CC and BCC
                            // $mail->addCC("cc@example.com");
                            // $mail->addBCC("bcc@example.com");
                            // Send HTML or Plain Text Email
                            $mail->isHTML(true);
                            $mail->Subject = "LOGGED IN?";
                            $mail->Body = "<p>Good Day".$username." Always Remember to Logout after you use the system </p>";
                            $mail->AltBody = "This is the plain text version of the email content";
                            // mail system
                            if(!$mail->send()) 
                            {
                                echo "Mailer Error: " . $mail->ErrorInfo;
                            } else
                            {
                                echo "Message has been sent successfully";
                            }
                            // end of mail
                            session_write_close();                            
                            //run a quick code to show active user
                            // Redirect user to welcome page
                            if ($stmt->num_rows ==1 && $_SESSION["usertype"] =="super_admin") {
                              header("location: index.php");
                            }elseif ($stmt->num_rows ==1 && $_SESSION["usertype"]=="admin"){
                                header("location: mfi/index.php");
                            //   header("location: ./mfi/admin/dashboard.php");
                            }
                            elseif ($stmt->num_rows ==1 && $_SESSION["usertype"]=="staff") {
                                if($_SESSION["employee_status"] == "Employed"){
                                    header("location: mfi/index.php");
                                  }
                                  elseif($_SESSION["employee_status"] == "Decommisioned"){
                                    $err = "Sorry You cannot login";
                                    $password = "";
                                  }
                            }
                            elseif ($stmt->num_rows ==1 && $_SESSION["usertype"]=="super_staff") {
                                header("location: ./modules/staff/dashboard.php");
                              }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}

include('functions/config.php');

?>

<html lang="en">
<head>
  <title>Login</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- test -->
  <!-- Material Kit CSS -->
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
</head>
<body>
    <div class="wrapper">
        <div class="content justify-content-between">
            <div class="container">
                <!-- Login form -->
                <!-- <div class="row"> -->
                    <div class="col-md-7" style="margin-left:auto; margin-right:auto;">
                    <div class="card">
                        <div class="card-header card-header-primary">
                        <h4 class="card-title">Login</h4>
                        <h4 class="card-title"><?php echo $err;?></h4>
                        <p class="card-category">Sign in</p>
                        </div>
                        <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <label class="bmd-label-floating">Username</label>
                                    <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
                                    <span class="help-block"><?php echo $username_err; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <label class="bmd-label-floating">Password</label>
                                    <input type="password" name="password" class="form-control" id="">
                                    <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Login</button>
                            <button type="reset" class="btn btn-danger ">Reset</button>
                            <div class="clearfix"></div>
                        </form>
                        </div>
                    </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
</body>
</html>