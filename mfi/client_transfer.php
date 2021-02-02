<?php
$page_title = "Client Transfer";
include('header.php');
?>
<!-- Content added here -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Client Transfer</h4>
            <p class="category">Category subtitle</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Select Branch</label>
                  <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Wuse II</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>



            </div>

            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Loan Officer</label>
                  <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Leroy Sane</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Group</label>
                  <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Saving Group</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <button type="button" class="btn btn-primary">Fetch Clients</button>
              </div>

            </div>

            <div class="row" style="margin-top: 30px;">
              <div class="col-md-12">
                <table id="example" class="display" style="width:100%">
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Client Name</th>
                      <th>Account Number</th>
                      <th>Group Name</th>
                      <th>Branch</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="">

                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div>
                      </td>
                      <td>Adamu Bature</td>
                      <td>0045798732</td>
                      <td>John Union I</td>
                      <td>Wuse II</td>

                    </tr>
                    <tr>
                      <td><div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="">

                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div></td>
                        <td>Adamu Bature</td>
                      <td>0045798732</td>
                      <td>John Union I</td>
                      <td>Garki</td>

                    </tr>
                    <tr>
                      <td><div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="">

                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div></td>
                        <td>Adamu Bature</td>
                      <td>0045798732</td>
                      <td>John Union I</td>
                      <td>Gwarinpa</td>

                    </tr>
                    <tr>
                      <td><div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="">

                            <span class="form-check-sign">
                              <span class="check"></span>
                            </span>
                          </label>
                        </div></td>
                      <td>Christian Tanko</td>
                      <td>0045798732</td>
                      <td>John Union I</td>
                      <td>Gwarinpa</td>

                    </tr>


                  </tbody>

                </table>

                <script>
                  $(document).ready(function() {
                    $('#example').DataTable();
                  });
                </script>

              </div>

            </div>

            <div class="row">
              <div class="col-md-6">
                <button type="button" class="btn btn-primary">Next <i class="material-icons"></i> </button>
              </div>
         </div>

         <div class="row" style="margin-top: 20px;">



              <div class="col-md-6">
                    <p><b>Select Action</b></p>
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Select Branch</label>
                  <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Wuse II</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>



            </div>

            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Loan Officer</label>
                  <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Leroy Sane</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-6">

                <div class="form-group">
                  <label for="exampleFormControlSelect1">Group</label>
                  <select class="form-control" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Saving Group</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>

            
            <div class="row">
              <div class="col-md-6">
                <button type="button" class="btn btn-primary">Sumbit For Approval</button>
              </div>

            </div>


        </div>
      </div>


    </div>
  </div>






  <?php
  include('footer.php');
  ?>