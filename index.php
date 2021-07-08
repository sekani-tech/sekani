<?php

    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
    
        <div class="container-fluid">
          <!-- your content here -->

          <div class="card">
                <div class="card-header card-header-primary">
                  <h2 class="card-title text-center">Dashboard</h2>
                  <p class="card-category text-center">Super Admin Dashboard</p>
                </div>
    </div>
          <!-- First Row Begins -->
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_balance</i>
                  </div>
                  <p class="card-category">Registered Institutions</p>
                  <h3 class="card-title"><b>8</b>
                    <small>MFIs</small>
                  </h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                <i class="material-icons text-primary">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">people</i>
                  </div>
                  <p class="card-category">Online Users</p>
                  <h3 class="card-title"><b>4</b></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-primary">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            
        
          </div>
          <!-- First Row Ends -->

          <!-- Second Row Begins -->
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">monetization_on</i>
                  </div>
                  <p class="card-category">Total Disbursed Loans</p>
                  <h3 class="card-title"><b>$34,245,000</b></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <i class="material-icons text-primary">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">account_balance_wallet</i>
                  </div>
                  <p class="card-category">Total Outstandings Loans & Collections</p>
                  <h3 class="card-title"><b>$34,245,000</b></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <i class="material-icons text-primary">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">payment</i>
                  </div>
                  <p class="card-category">Total Savings</p>
                  <h3 class="card-title"><b>75</b></h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                <i class="material-icons text-primary">date_range</i> Last 24 Hours
                  </div>
                </div>
              </div>
            </div>
            
           
          </div>
          <!-- Second Row Ends -->
          

          <!-- Third Row Begins -->
          <div class="row">
          <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Institutions</h4>
                  <p class="card-category">Registered MFIs</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-primary">
                      <th>S/N</th>
                      <th>Name of Institutions</th>
                      <th>L.G.A</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>DGMFB</td>
                        <td>Municipal Area Council</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Rightway</td>
                        <td>Curaçao</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>GreenBacks</td>
                        <td>Calabar Municipal</td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>REALAID</td>
                        <td>Ikorodu</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Online Users</h4>
                  <p class="card-category">Online Users by Institutions</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-primary">
                      <th>ID</th>
                      <th>Name</th>
                      <th>Institution</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Dakota Rice</td>
                        <td>RealAid</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Minerva Hooper</td>
                        <td>DGMFB</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Sage Rodriguez</td>
                        <td>GreenBacks</td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Philip Chaney</td>
                        <td>EasyLife</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>



          </div>
          <!-- Third Row Ends -->


        </div>
      </div>

<?php

    include("footer.php");

?>