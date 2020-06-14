 <?php
 include("../../functions/connect.php");
 session_start();
 $out= '';
 $logo = $_SESSION['int_logo'];
$name = $_SESSION['int_name'];
  $out ='
    <div class="card-body">
      <div style="margin:auto; text-align:center;">
      <img style = "height: 200px; width: 200px;" src="'.$logo.' alt="sf">
      <h2>'.$name.'</h2>
      <h4>Sectoral Analysis of Loans and Advances</h4>
      <P>From: 24/05/2020  ||  To: 24/05/2020</P>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header card-header-primary">
      <h4 class="card-title">Sectoral Analysis of Loans and Advances</h4>
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
        <thead>
          <th style="font-weight:bold;">SECTOR</th>
          <th style="font-weight:bold; text-align: center;">NUMBER OF LOANS</th>
          <th style="font-weight:bold; text-align: center;">AMOUNT <br> &#x20A6</th>
          <th style="font-weight:bold; text-align: center;">%</th>
        </thead>
        </thead>
        <tbody>
            <tr>
                <td>Agriculture & Mining & Quarry</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Manufacturing & Trade & Commerce</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Trade & Commerce</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Transport & Estate & Rent/Housing</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Consumer/Personal</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Health</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Education</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Tourism &</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Purchase of Shares</td>
                <td></td>
                <td></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td>Others(Specify)</td>
                <td ></td>
                <td ></td>
                <td style="background-color:bisque;"></td>
            </tr>
            <tr>
                <td><b>TOTAL</b></td>
                <td style="background-color:bisque;"><b></b></td>
                <td style="background-color:bisque;"><b></b></td>
                <td style="background-color:bisque;"><b></b></td>
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
    ';
    echo $out;
?>
