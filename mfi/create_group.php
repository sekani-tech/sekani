<?php

$page_title = "Create Group";
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
                <h4 class="card-title">Create Group</h4>
                <p class="card-category">Fill in all important data</p>
              </div>
              <div class="card-body">
              <form id="form" action="" method="POST">
                  <div class = "row">
                    <div class = "col-md-12">
                      <div class = "form-group">
                        <!-- Group info _ Tab1 -->
                    <div class="tab"><h3> Group info:</h3>
                        <div class="col-md-4">
                            <label class = "bmd-label-floating">Group Name *:</label>
                            <input type="text" name="" id="" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Branch Name *:</label>
                            <select name="" id="" class="form-control" required>
                                <option value="">...........</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Loan Officer *:</label>
                            <select name="" id="" class="form-control" required>
                                <option value="">...........</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Registration Date *:</label>
                            <input type="date" name="" class="form-control" id="" required>
                        </div>
                        <div class="col-md-4">
                            <label for="">Registration :</label>
                            <select name="" id="" class="form-control">
                                <option value="Informal">Informal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Day :</label>
                            <select name="" id="" class="form-control" placeholder="Select an Option">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Frequency :</label>
                            <select name="" id="" class="form-control" placeholder="Select an Option">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Location :</label>
                            <input type="text" name="" class="form-control" id="">
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Time :</label>
                            <input type="text" name="" class="form-control" id="">
                        </div>
                    </div>    
                    <!-- Clients Selection -->
                    <div class="tab"><h3> Select Clients:</h3>
                        <div class="col-md-4">
                            <label for="">Clients</label>
                            <input type="text" name="" class="form-control" id="">
                        </div>
                        <table class="table">
                            <thead>
                                <th style="font-weight:bold;">Client ID</th>
                                <th style="font-weight:bold;">Client Name</th>
                            </thead>
                            <tbody>
                                <td></td>
                                <td></td>
                            </tbody>
                        </table>
                    </div>
                    <!-- /Client Selection -->
                    <!-- Oberview -->
                    <div class="tab">
                        <h3>Overview:</h3>
                        <div class="col-md-4">
                            <label class = "bmd-label-floating">Group Name *:</label>
                            <input type="text" name="" id="" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Branch Name *:</label>
                            <select name="" id="" class="form-control" readonly>
                                <option value="">...........</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Loan Officer *:</label>
                            <select name="" id="" class="form-control" readonly>
                                <option value="">...........</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Registration Date *:</label>
                            <input type="date" name="" class="form-control" id="" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Registration :</label>
                            <select name="" id="" class="form-control">
                                <option value="Informal">Informal</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Day :</label>
                            <select name="" id="" class="form-control" placeholder="Select an Option" readonly>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Frequency :</label>
                            <select name="" id="" class="form-control" placeholder="Select an Option" readonly>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Location :</label>
                            <input type="text" name="" class="form-control" id="" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Meeting Time :</label>
                            <input type="text" name="" class="form-control" id="" readonly>
                        </div>
                        <table class="table">
                            <thead>
                                <th style="font-weight:bold;">Client ID</th>
                                <th style="font-weight:bold;">Client Name</th>
                            </thead>
                            <tbody>
                                <td></td>
                                <td></td>
                            </tbody>
                        </table>
                    </div>
                    <!-- Buttons -->
                    <div style="overflow:auto;">
                          <div style="float:right;">
                            <button class="btn btn-primary pull-right" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <button class="btn btn-primary pull-right" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                          </div>
                        </div>
                      <!-- Steppers -->
                      <!-- Circles which indicates the steps of the form: -->
                      <div style="text-align:center;margin-top:40px;">
                          <span class="step"></span>
                          <span class="step"></span>
                          <!-- <span class="step"></span> -->
                          <span class="step"></span>
                          <span class="step"></span>
                          <span class="step"></span>
                          <span class="step"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

                  
                  <!-- /stepper  -->
                </div>
              </div>
            </div>
            <!-- <div class="col-md-4">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="../assets/img/faces/marc.jpg" />
                  </a>
                </div>
                 Get session data and populate user profile 
                <div class="card-body">
                  <h6 class="card-category text-gray">CEO / Co-Founder</h6>
                  <h4 class="card-title">Alec Thompson</h4>
                  <p class="card-description">
                    Sekani Systems
                  </p>
                   <a href="#pablo" class="btn btn-primary btn-round">Follow</a> 
                </div>
              </div>
            </div> -->
          </div>
          <!-- /content -->
        </div>
      </div>
      <style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

/* #regForm {
  background-color: #ffffff;
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
} */

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #a13cb6;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #9e38b5;
}
</style>
      <script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("form").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = true;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
<?php

    include("footer.php");

?>