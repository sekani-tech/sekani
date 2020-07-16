<?php
include("connect.php");
session_start();
require_once "../bat/phpmailer/PHPMailerAutoload.php";
$sessint_id = 5;
$int_email = 'dgmfb@gmail.com';
$int_name = 'DGMFB';
$nm = 'Tech Support';
$int_logo = 'https://firebasestorage.googleapis.com/v0/b/recipeapp-6e1ce.appspot.com/o/DGMFB.png?alt=media&token=c4d6cb90-3bc3-47be-82d3-71b1a26d9b27';
$quy = "SELECT * FROM staff WHERE int_id = '$sessint_id' AND employee_status = 'Employed'";
$rult = mysqli_query($connection, $quy);
if (mysqli_num_rows($rult) > 0) {
  while ($row = mysqli_fetch_array($rult))
      {
        $remail = $row['email'];
        $roleid = $row['org_role'];
        $quyd = "SELECT * FROM permission WHERE role_id = '$roleid'";
        $rlot = mysqli_query($connection, $quyd);
        $tolm = mysqli_fetch_array($rlot);
        $vaul = $tolm['vault_email'];
        
        if ($vaul == 1 || $vaul == "1") {
        $mail = new PHPMailer;
        $mail->From = $int_email;
        $mail->FromName = $int_name;
        $mail->addAddress($remail);
        $mail->addReplyTo($int_email, "Reply");
        $mail->isHTML(true);
        $mail->Subject = "Vault Alert from $int_name";
        $mail->Body = "<!DOCTYPE html>
        <html>
            <head>
            <style>
            .lon{
              height: 100%;
                background-color: #eceff3;
                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            .main{
                margin-right: auto;
                margin-left: auto;
                width: 550px;
                height: auto;
                background-color: white;

            }
            .header{
                margin-right: auto;
                margin-left: auto;
                width: 550px;
                height: auto;
                background-color: white;
            }
            .logo{
                margin-right:auto;
                margin-left: auto;
                width:auto;
                height: auto;
                background-color: white;

            }
            .text{
                padding: 20px;
                font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            table{
                padding:30px;
                width: 100%;
            }
            table td{
                font-size: 15px;
                color:rgb(65, 65, 65);
            }
        </style>
            </head>
            <body>
              <div class='lon'>
                <div class='header'>
                    <div class='logo'>
                    <img style='margin-left: 200px; margin-right: auto; height:150px; width:150px;'class='img' src='$int_logo'/>
                </div>
            </div>
                <div class='main'>
                    <div class='text'>
                        Dear User,
                        <h2 style='text-align:center;'>Notification of Vault Alert</h2>
                        this is to notify you that a vault-In transaction has been made in $int_name,
                         by $nm Kindly confirm with your bank.<br/><br/>
                         Please see the details below
                    </div>
                    <table>
                        <tbody>
                            <div>
                          <tr>
                            <td> <b >Account Number</b></td>
                            <td >Not Available During Test</td>
                          </tr>
                          <tr>
                            <td > <b>From</b></td>
                            <td >Not Available During Test</td>
                          </tr>
                          <tr>
                            <td > <b>Reference</b></td>
                            <td >Not Available During Test</td>
                          </tr>
                          <tr>
                            <td > <b>Reference Id</b></td>
                            <td >Not Available During Test</td>
                          </tr>
                          <tr>
                            <td> <b>Transaction Amount</b></td>
                            <td>Not Available During Test</td>
                          </tr>
                          <tr>
                            <td> <b>Transaction Date/Time</b></td>
                            <td>Not Available During Test</td>
                          </tr>
                          <tr>
                            <td> <b>Value Date</b></td>
                            <td>Not Available During Test</td>
                          </tr>
                          <tr>
                            <td> <b>Account Balance</b></td>
                            <td>&#8358;Not Available During Test</td>
                          </tr>
                        </tbody>
                        <!-- Optional JavaScript -->
                        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                        <script src='https://code.jquery.com/jquery-3.4.1.slim.min.js' integrity='sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n' crossorigin='anonymous'></script>
                        <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js' integrity='sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo' crossorigin='anonymous'></script>
                        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js' integrity='sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6' crossorigin='anonymous'></script>
                      </body>
                    </table>
                </div>
              </div>
            </body>
        </html>";
        $mail->AltBody = "This is the plain text version of the email content";
      }
      }
                   // mail system
                   $sd =mysqli_num_rows($rult);
                   if(!$mail->send()) 
                   {
                     echo "Didnt Send";
                     echo $sd." people recieved it";
                    //  echo header ("Location: ../mfi/teller_journal.php?message6=$randms");
                   } else
                   {
                     echo "Email Sent";
                     echo $sd." people recieved it"; 
                    //  echo header ("Location: ../mfi/teller_journal.php?message1=$randms");;
                   }
  } 
?>