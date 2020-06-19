              <?php
              include("../../functions/connect.php");
              session_start();
              $out= '';
              $logo = $_SESSION['int_logo'];
              $name = $_SESSION['int_name'];
              $out ='
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
                            <td></td>
                            <!-- <td style="background-color:bisque;"></td> -->
                        </tr>
                        <tr>
                            <td>10763</td>
                            <td><b>Non-Performing(Portfolio-At-Risk)</b></td>
                            <td></td>
                            <!-- <td style="background-color:bisque;"></td> -->
                        </tr>
                        <tr>
                            <td>10764</td>
                            <td>Pass & Watch</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>10765</td>
                            <td>Substandard</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>10766</td>
                            <td>Doubtful</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>10767</td>
                            <td>Lost</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>10768</td>
                            <td>Total Portfolio-At-Risk</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Interest In Suspense</td>
                            <!-- <td></td> -->
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>10769</td>
                            <td><b>Total</b></td>
                            <!-- <td style="background-color:bisque;"></td> -->
                            <td style="background-color:bisque;"></td>
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
          </div>';
          echo $out;
          ?>
