          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">

              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Requested Sent SMS</h4>
                </div>
                <div class="card-body">
                  <?php

                  $smsSearchConditions = [
                    'int_id' => $sessint_id,
                    'branch_id' => $branch_id
                  ];
                  $findSMS = selectAllWithOrder('sms_record', $smsSearchConditions, "action_stamp", "ASC");

                  ?>
                  <table id="tablee" class="table table-striped table-bordered">
                    <thead>
                      <th>Transaction Date</th>
                      <th>Sent Time</th>
                      <th>Mobile No</th>
                      <th>Status</th>
                      <th>Message</th>
                    </thead>
                    <tbody>
                      <?php

                      foreach ($findSMS as $keys => $rows) {

                      ?>
                        <tr>
                          <td> <?php echo $rows['transaction_date'] ?> </td>
                          <td> <?php echo $rows['action_stamp'] ?> </td>
                          <td> <?php echo $rows['mobile_no'] ?> </td>
                          <td> <?php echo $rows['status'] ?> </td>
                          <td> <?php echo $rows["message"] ?> </td>
                        </tr>
                      <?php

                      }

                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--//report ends here -->
              <!-- <div class="card">
                <div class="card-body">
                  <a href="" class="btn btn-primary">Back</a>
                  <a href="" class="btn btn-success btn-left">Print</a>
                </div>
              </div> -->
            </div>
          </div>

          <script>
          $(document).ready(function() {
    $('#tablee').DataTable();
} );
          </script>