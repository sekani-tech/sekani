              <?php
              include("../../functions/connect.php");
              session_start();
              $out= '';
              $logo = $_SESSION['int_logo'];
              $sessint_id = $_SESSION['int_id'];
              $name = $_SESSION['int_name'];

              $start = $_POST['start'];
              $end = $_POST['end'];
              ?>
              <?php
              // pass and watch
              $fuf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND counter < '30' AND (duedate BETWEEN '$start' AND '$end')";
              $difo = mysqli_query($connection, $fuf);
              $do = mysqli_fetch_array($difo);
              $pandw = $do['principal_amount'];

              // Substandard
              $dffedr = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND counter BETWEEN '30' AND '60' AND (duedate BETWEEN '$start' AND '$end')";
              $sdd = mysqli_query($connection, $dffedr);
              $d = mysqli_fetch_array($sdd);
              $sub = $d['principal_amount'];

              // doubtful
              $zxrs = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND counter BETWEEN '60' AND '90' AND (duedate BETWEEN '$start' AND '$end')";
              $dsdfs = mysqli_query($connection, $zxrs);
              $io = mysqli_fetch_array($dsdfs);
              $doub = $io['principal_amount'];

              // lost
              $sdsedw = "SELECT SUM(principal_amount) AS principal_amount FROM loan_arrear WHERE int_id = '$sessint_id' AND installment >= '1' AND counter BETWEEN '90' AND '100000' AND (duedate BETWEEN '$start' AND '$end')";
              $sdas = mysqli_query($connection, $sdsedw);
              $sds = mysqli_fetch_array($sdas);
              $los = $sds['principal_amount'];

              // total portfolio at risk
              $tpar = $pandw + $sub + $doub + $los;

              // total interest in suspense
              $dsio = "SELECT SUM(interest_amount) AS interest_amount FROM loan_arrear WHERE installment >= '1' AND int_id = '$sessint_id' AND (duedate BETWEEN '$start' AND '$end')";
              $dso = mysqli_query($connection, $dsio);
              $is = mysqli_fetch_array($dso);
              $fdl = $is['interest_amount'];

              // Total Outstanding Derived
                $dd = "SELECT SUM(interest_amount) AS interest_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND (duedate > '$end')";
                $sdoi = mysqli_query($connection, $dd);
                $e = mysqli_fetch_array($sdoi);
                $interest = $e['interest_amount'];

                $dfdf = "SELECT SUM(principal_amount) AS principal_amount FROM loan_repayment_schedule WHERE installment >= '1' AND int_id = '$sessint_id' AND (duedate > '$end')";
                $sdswe = mysqli_query($connection, $dfdf);
                $u = mysqli_fetch_array($sdswe);
                $prin = $u['principal_amount'];

                $outstanding = $prin + $interest;

                // Performing Loan
                $performing = $outstanding - ($fdl + $tpar);
              ?>
              <?php
              $total = $performing + $fdl + $tpar;
              ?>
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Summary of Loan Classification</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                    <thead>
                      <th style="font-weight:bold;">S/N</th>
                      <th style="font-weight:bold; text-align: center;"></th>
                      <th style="font-weight:bold; text-align: center;">AMOUNT <br> &#x20A6</th>
                    </thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10762</td>
                            <td>Performing</td>
                            <td style=" text-align: center;"><?php echo number_format($performing, 2);?></td>
                            <!-- <td style="background-color:bisque;"></td> -->
                        </tr>
                        <tr>
                            <td>10763</td>
                            <td><b>Non-Performing(Portfolio-At-Risk)</b></td>
                            <td style=" text-align: center;"></td>
                            <!-- <td style="background-color:bisque;"></td> -->
                        </tr>
                        <tr>
                            <td>10764</td>
                            <td>Pass & Watch</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque; text-align: center;"><?php echo number_format($pandw, 2);?></td>
                        </tr>
                        <tr>
                            <td>10765</td>
                            <td>Substandard</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque; text-align: center;"><?php echo number_format($sub, 2);?></td>
                        </tr>
                        <tr>
                            <td>10766</td>
                            <td>Doubtful</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque; text-align: center;"><?php echo number_format($doub, 2);?></td>
                        </tr>
                        <tr>
                            <td>10767</td>
                            <td>Lost</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque; text-align: center;"><?php echo number_format($los, 2);?></td>
                        </tr>
                        <tr>
                            <td>10768</td>
                            <td><b>Total Portfolio-At-Risk</b></td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque; font-weight:bold; text-align: center;"><?php echo number_format($tpar, 2);?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Interest In Suspense</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque; text-align: center;"><?php echo number_format($fdl, 2);?></td>
                        </tr>
                        <tr>
                            <td>10769</td>
                            <td><b>Total</b></td>
                            <!-- <td style="background-color:bisque;"></td> -->
                            <td style="background-color:bisque; font-weight:bold; text-align: center;"><?php echo number_format($total, 2);?></td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--//report ends here -->
              <div class="card">
                 <div class="card-body">
                  <a href="" class="btn btn-primary">Back</a>
                  <a href="" class="btn btn-success btn-left">Print</a>
                 </div>
               </div> 
            </div>
          </div>
