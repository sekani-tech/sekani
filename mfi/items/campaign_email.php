<style>
.dataTable>thead>tr>th, .dataTable>tbody>tr>th, .dataTable>tfoot>tr>th, .dataTable>thead>tr>td, .dataTable>tbody>tr>td, .dataTable>tfoot>tr>td {
    /* padding: 0.6rem 0 0.6rem 0.2rem !important; */
    font-weight: 400;
}

table.dataTable thead th, table.dataTable thead td {
    padding: 10px 18px;
    border-bottom: 1px solid #ddd;
}

.dataTable>thead>tr>th {
    font-size: 0.9rem;
    padding: 0.6rem 0 0.6rem 0.2rem !important;
}

table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
}
</style>
<!-- <div class="card"> -->
                <!-- <div class="card-header card-header-primary">
                  <h4 class="card-title">Email Campaigns</h4>
                </div> -->
                <!-- <div class="card-body"> -->
                  <table class="table table-bordered" id="email-campaigns" style="width:100%">
                    <thead>
                      <th style="font-weight:bold;">Campaign Name</th>
                      <th style="font-weight:bold">Description</th>
                      <th style="font-weight:bold;">Type</th> 
                      <th style="font-weight:bold;">Actions</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Christmas</td>
                            <td>Christmas message to all customers to be sent on christmas day</td>
                            <td>Holiday</td>
                            <td>
                            <button type="submit" class="btn btn-primary">Activate</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Loan Success</td>
                            <td>so many things i can't explain, some extra stuff too</td>
                            <td>Loans</td>
                            <td>
                            <button type="reset" class="btn btn-danger">Deactivate</button>
                            </td>
                        </tr>
                    </tbody>
                  </table>
                <!-- </div>
              </div> -->
 <script>
              $(document).ready(function () {
                
                 // email campaigns datatable
                $('#email-campaigns').DataTable(); 
            });
     </script>