<?php

$page_title = "Loans";
$destination = "index.php";
    include("header.php");

?>
<!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Loans</h4>
                  <!-- Insert number users institutions -->
                  <p class="card-category"><?php echo 0; ?> Active loans || <a href="lend.php">Lend Client</a></p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <!-- <th>
                          ID
                        </th> -->
                        <th>Name</th>
                        <th>
                          Principal
                        </th>
                        <th>
                          Interest Value
                        </th>
                      </thead>
                      <tbody>
                          <th></th>
                          <th></th>
                          <th></th>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php

    include("footer.php");

?>