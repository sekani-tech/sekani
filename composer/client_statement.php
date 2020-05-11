<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once('../functions/connect.php');
?>
<?php
if (isset($_GET["message1"])) {
    $key = $_GET["message1"];
    // $out = $_SESSION["lack_of_intfund_$key"];
    echo '<script type="text/javascript">
    $(document).ready(function(){
        swal({
            type: "success",
            title: "Success",
            text: "Statement Download complete!",
            showConfirmButton: false,
            timer: 2000
        })
    });
    </script>
    ';
    $_SESSION["lack_of_intfund_$key"] = null;
  }
?>
<?php
if(isset($_GET["edit"])) {
    $id = $_GET["edit"];
    $query1 = mysqli_query($connection, "SELECT * FROM client WHERE id='$id'");
    if (count([$query1]) == 1) {
        $a = mysqli_fetch_array($query1);
        $fname = $a['firstname'];
        $lname = $a['lastname'];
        $int_id = $a['int_id'];
        $actype = $a['account_type'];
        $acc_no = $a['account_no'];
        $branch = $a['branch_id'];
        $query2 = mysqli_query($connection, "SELECT * FROM institutions WHERE int_id='$int_id'");
        if (count([$query2]) == 1) {
            $b = mysqli_fetch_array($query2);
            $intname = $b['int_name'];
            $logo = $b['int_name'];
            $web = $b['website'];
        }
        $branchid = mysqli_query($connection, "SELECT * FROM branch WHERE id='$branch'");
        if (count([$branchid]) == 1) {
         $c = mysqli_fetch_array($branchid);
         $branch_name = strtoupper($c['name']);
        $branch_address = $c['location'];
        }
        $acount = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
        if (count([$acount]) == 1) {
        $d = mysqli_fetch_array($acount);
        $currtype = $d['currency_code'];
        }
        $trans = mysqli_query($connection, "SELECT * FROM account WHERE account_no='$acc_no'");
        if (count([$trans]) == 1) {
        $e = mysqli_fetch_array($trans);
        $client_id = $e['client_id'];
        }
        
    }

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML('
        <link rel="stylesheet" media="print"  href="pdf/util.css">
        <link rel="stylesheet" href="pdf/main.css">    
        <header class="clearfix">
        <div id="logo">
          <img src="'.$_SESSION["int_logo"].'" height="80" width="80">
        </div>
        <h1>'.$_SESSION["int_name"].' - Client Statement</h1>
        <div id="project" class="clearfix">
            <div><span>Branch name</span>'.$branch_name.'</div>
            <div><span>Branch address</span>'.$branch_address.'</div>
            <div><span>Client name</span>'.$fname.' '.$lname.'</div>
            <div><span>Currency</span>'.$currtype.'</div>
            <div><span>Account number</span>'.$acc_no.'</div>
            <div><span>Total debit </span> Head Office Branch</div>
            <div><span>Total credit </span> August 17, 2015</div>
            <div><span>Statement period:</span> September 17, 2015</div>
        </div>
        </header>
    
    <div class="limiter">
        <div class="wrap-table100">
            <div class="table100">
                <table>
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">Transaction-Date</th>
                            <th class="column2">Value Date</th>
                            <th class="column3">Reference</th>
                            <th class="column4">Debits</th>
                            <th class="column5">Credits</th>
                            <th class="column6">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td class="column1">2017-09-29 01:22</td>
                                <td class="column2">200398</td>
                                <td class="column3">iPhone X 64Gb Grey</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-28 05:57</td>
                                <td class="column2">200397</td>
                                <td class="column3">Samsung S8 Black</td>
                                <td class="column4">$756.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$756.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-26 05:57</td>
                                <td class="column2">200396</td>
                                <td class="column3">Game Console Controller</td>
                                <td class="column4">$22.00</td>
                                <td class="column5">2</td>
                                <td class="column6">$44.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-25 23:06</td>
                                <td class="column2">200392</td>
                                <td class="column3">USB 3.0 Cable</td>
                                <td class="column4">$10.00</td>
                                <td class="column5">3</td>
                                <td class="column6">$30.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-24 05:57</td>
                                <td class="column2">200391</td>
                                <td class="column3">Smartwatch 4.0 LTE Wifi</td>
                                <td class="column4">$199.00</td>
                                <td class="column5">6</td>
                                <td class="column6">$1494.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-23 05:57</td>
                                <td class="column2">200390</td>
                                <td class="column3">Camera C430W 4k</td>
                                <td class="column4">$699.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$699.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-22 05:57</td>
                                <td class="column2">200389</td>
                                <td class="column3">Macbook Pro Retina 2017</td>
                                <td class="column4">$2199.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$2199.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-21 05:57</td>
                                <td class="column2">200388</td>
                                <td class="column3">Game Console Controller</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-19 05:57</td>
                                <td class="column2">200387</td>
                                <td class="column3">iPhone X 64Gb Grey</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-18 05:57</td>
                                <td class="column2">200386</td>
                                <td class="column3">iPhone X 64Gb Grey</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-22 05:57</td>
                                <td class="column2">200389</td>
                                <td class="column3">Macbook Pro Retina 2017</td>
                                <td class="column4">$2199.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$2199.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-21 05:57</td>
                                <td class="column2">200388</td>
                                <td class="column3">Game Console Controller</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-19 05:57</td>
                                <td class="column2">200387</td>
                                <td class="column3">iPhone X 64Gb Grey</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            <tr>
                                <td class="column1">2017-09-18 05:57</td>
                                <td class="column2">200386</td>
                                <td class="column3">iPhone X 64Gb Grey</td>
                                <td class="column4">$999.00</td>
                                <td class="column5">1</td>
                                <td class="column6">$999.00</td>
                            </tr>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    ');
    // $stylesheet = file_get_contents('style.css');
    
    // $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->Output();
}
else{
    echo 'Data not found';
}

?>