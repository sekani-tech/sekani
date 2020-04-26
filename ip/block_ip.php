<?php
include("material.php");
?>
<?php
  include("connect.php");
  session_start();
?>

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
  $gtp = mysqli_query($connection, "SELECT * FROM ip_blacklist WHERE ip_add = '$ip'");
  if (count([$gtp]) == 1) {
  $x = mysqli_fetch_array($gtp);
  $vm = $x['trial'];
  }
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
    $xm = "Your IP address Has Been Blocked";
  } else {
    $newcode = $vm + 1;
    $mmm = mysqli_query($connection, "UPDATE ip_blacklist SET trial = '$newcode' WHERE ip_add = '$ip'");
}
} else {
  echo '<script type="text/javascript">
        $(document).ready(function(){
            swal({
                type: "The Internet?",
                title: "IP",
                text: "THIS IP IS GOOD TO GO",
                showConfirmButton: false,
                timer: 4000
            })
        });
        </script>';
  $xm = "Your Device Are Good To Go";
}
?>
<div class="card text-center">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item">
        <a class="nav-link active" href="#0">IP: <?php echo $ip; ?> </a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $xm; ?></h4>
    <p class="card-text">
    <form class="form">
        <p class="description text-center" style="color: green;">CONTACT YOUR INSTITUTION FOR UNBLOCK</p>
            <div class="card-body">
                <div class="form-group bmd-form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text"><i class="material-icons">information</i></div>
                        </div>
                        <input type="text" name="pass" id="opo" placeholder="Talk To Us" class="form-control" required>
                    </div>
                </div>
                <div class="justify-content-center">
                    <button type="submit" class="btn btn-primary btn-link btn-wd btn-lg">SEND</button>
                </div>
            </div>
    </form>
    </p>
  </div>
</div>