<?php 
include("../../functions/connect.php");
session_start();
$out= '';
$logo = $_SESSION['int_logo'];
$name = $_SESSION['int_name'];
$out = '
            
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Schedule of Micro Loans by Lending Models</h4>
                </div>
                <div class="card-body">
                  <table class="table">
                    <thead>
                    <thead>
                      <th style="font-weight:bold;">LENDING MODEL</th>
                      <th style="font-weight:bold; text-align: center;">NUMBER</th>
                      <th style="font-weight:bold; text-align: center;">AMOUNT <br> &#x20A6</th>
                      <th style="text-align: center; font-weight:bold;">%</th>
                    </thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Individual Account</td>
                            <td></td>
                            <td></td>
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>Joint Account</td>
                            <td></td>
                            <td></td>
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>Coporate Account</td>
                            <td></td>
                            <td></td>
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>Group Account</td>
                            <td></td>
                            <td></td>
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>Staff Account</td>
                            <td></td>
                            <td></td>
                            <td style="background-color:bisque;"></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td style="background-color:bisque;"></td>
                            <td style="background-color:bisque;"></td>
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
';
          echo $out;
          ?>
