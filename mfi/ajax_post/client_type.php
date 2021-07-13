<?php
include("../../functions/connect.php");
$output1 = '';
$output2 = '';
$output3 = '';
session_start();
if (isset($_POST['id'])) {
    function branch_option($connection)
    {
        $br_id = $_SESSION["branch_id"];
        $sint_id = $_SESSION["int_id"];
        $fod = "SELECT * FROM branch WHERE int_id = '$sint_id' AND parent_id='$br_id' || id = '$br_id'";
        $dof = mysqli_query($connection, $fod);
        $out = '';
        while ($row = mysqli_fetch_array($dof)) {
            $out .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
        }
        return $out;
    }

    function fill_officer($connection)
    {
        $sint_id = $_SESSION["int_id"];
        $orgs = selectAll('staff', ['int_id'=>$sint_id, 'employee_status'=> 'Employed']);
        $out = '';
        foreach ($orgs as $row) {
            $out .= '<option value="' . $row["id"] . '">' . $row["display_name"] . '</option>';
        }
        return $out;
    }

    function fill_state($connection)
    {

        $orgs = selectAll('states');
        $out = '';
        foreach ($orgs as $org) {
            $out .= '<option value="' . $org["name"] . '">' . $org["name"] . '</option>';
        }
        return $out;
    }

    //  Data for Corporate
    if ($_POST['id'] == 'Corporate') {
        $output1 = '
        <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >RC Number</label>
                        <input  type="text"  style="text-transform: uppercase;" class="form-control" name="rc_number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="">Date of Registration:</label>
                        <input  type="date" class="form-control" name="date_of_birtha">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label >Registered Name</label>
                <input  type="text"  style="text-transform: uppercase;" class="form-control" name="display_namea">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label >Email address</label>
                <input  type="email" class="form-control" name="emaila">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label >Registered Address</label>
                <input type="text" style="text-transform: uppercase;"$br_id class="form-control" name="addressa">
            </div>
        </div>

        <div class="col-md-4">
        <div class="form-group">
            <label class="">Branch:</label>
            <select class="form-control" name="branch">
            ' . branch_option($connection) . '
            </select>
        </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <div class="form-group">
                <label for="">Account Officer:</label>
                <select name="acct_ofa" class="form-control" id="">
                <option value="">select account officer</option>
                ' . fill_officer($connection) . '
                </select>
            </div>
            </div>
        </div>
        
            <div class="col-md-4">
            <div class="form-group">
                <label for="">Name of Next of Kin:</label>
                <input type="text"  class="form-control" name="nok">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label for="">Relationship:</label>
                <input type="text"  class="form-control" name="relationship_Nok">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group">
                <label for="">Phone Number:</label>
                <input type="number"  class="form-control" name="numberof_Nok">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group">
                <label for="">Email Address</label>
                <input type="number"  class="form-control" name="email_Nok">
            </div>
            </div>
            

        <div class="col-md-12">
            <div class="form-group">
                <label></label>
                <input hidden type="text" style="text-transform: uppercase;" class="form-control">
            </div>
        </div>
        <div class ="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                    <label>Name of Signatries NO.1</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Address</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_address_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Phone</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_phone_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Gender</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_gender_one">
                    </div>
                </div>
                <div class="col-md-12">
            <div class="form-group">
              <label for="">State:</label>
              <select id="sig_one" class="form-control" style="text-transform: uppercase;" name="sig_state_one">
              ' . fill_state($connection) . '
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="sig_lga_one" id="sigone">
              </select>
            </div>
          </div>
          <div class="col-md-12">
                    <div class="form-group">
                    <label >Occupation</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_occu_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >BVN</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_bvn_one">
                    </div>
                </div>
                <div class="col-md-12">
                    <p><label for="">Active Alerts:</label></p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="sms_active_one" type="checkbox" value="1">
                            SMS
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="email_active_one" type="checkbox" value="1">
                            Email
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="file-upload-a" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload-a" name="sig_passport_one" type="file" class="inputFileHidden"/>
                    <label id="upload-a"> Select Passport</label>
                    <div id="upload-a"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-insert-a" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert-a" name="sig_signature_one" type="file" class="inputFileHidden"/>
                    <label id="iup-a"> Select Signature</label>
                    <div id="iup-a"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-enter-a" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-enter-a" type="file" name="sig_id_img_one" class="inputFileHidden"/>
                    <label id="rated-a"> Select ID</label>
                    <div id="rated-a"></div>
                </div>
                <style>
            input[type="file"]{
                display: none;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            </style>
                <div class="col-md-12">
                    <label for="">Id Type</label>
                    <select  name="sig_id_card_one" class="form-control " id="">
                        <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="Drivers License">Drivers license</option>
                        <option value="International Passport">International Passport</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Name of Signatries NO.2</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Address</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_address_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Phone</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_phone_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Gender</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_gender_two">
                    </div>
                </div>
                <div class="col-md-12">
            <div class="form-group">
              <label for="">State:</label>
              <select id="sig_two" class="form-control" style="text-transform: uppercase;" name="sig_state_two">
              ' . fill_state($connection) . '
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="sig_lga_two" id="sigtwo">
              </select>
            </div>
          </div>
          <div class="col-md-12">
                    <div class="form-group">
                    <label >Occupation</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_occu_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label>BVN</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_bvn_two">
                    </div>
                </div>
                <div class="col-md-12">
                    <p><label for="">Active Alerts:</label></p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="sms_active_two" type="checkbox" value="1">
                            SMS
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="email_active_two" type="checkbox" value="1">
                            Email
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="file-upload-b" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload-b" name="sig_passport_two" type="file" class="inputFileHidden"/>
                    <label id="upload-b"> Select Passport</label>
                    <div id="upload-b"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-insert-b" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert-b" name="sig_signature_two" type="file" class="inputFileHidden"/>
                    <label id="iup-b"> Select Signature</label>
                    <div id="iup-b"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-enter-b" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-enter-b" type="file" name="sig_id_img_two" class="inputFileHidden"/>
                    <label id="rated-b"> Select ID</label>
                    <div id="rated-b"></div>
                </div>
                <style>
            input[type="file"]{
                display: none;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            </style>
                <div class="col-md-12">
                    <label for="">Id Type</label>
                    <select  name="sig_id_card_two" class="form-control " id="">
                        <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="Drivers License">Drivers license</option>
                        <option value="International Passport">International Passport</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Name of Signatries NO.3</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Address</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_address_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Phone</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_phone_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >Gender</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_gender_three">
                    </div>
                </div>
                <div class="col-md-12">
            <div class="form-group">
              <label for="">State:</label>
              <select id="sig_three" class="form-control" style="text-transform: uppercase;" name="sig_state_three">
              ' . fill_state($connection) . '
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="sig_lga_three" id="sigthree">
              </select>
            </div>
          </div>
          <div class="col-md-12">
                    <div class="form-group">
                    <label >Occupation</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_occu_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <label >BVN</label>
                    <input  type="text" style="text-transform: uppercase;" class="form-control" name="sig_bvn_three">
                    </div>
                </div>
                <div class="col-md-12">
                    <p><label for="">Active Alerts:</label></p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="sms_active_three" type="checkbox" value="1">
                            SMS
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input class="form-check-input" name="email_active_three" type="checkbox" value="1">
                            Email
                            <span class="form-check-sign">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="file-upload-c" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-upload-c" name="sig_passport_three" type="file" class="inputFileHidden"/>
                    <label id="upload-c"> Select Passport</label>
                    <div id="upload-c"></div>
                </div>
            
                <div class="col-md-12">
                    <label for="file-insert-c" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-insert-c" name="sig_signature_three" type="file" class="inputFileHidden"/>
                    <label id="iup-c"> Select Signature</label>
                    <div id="iup-c"></div>
                </div>
                <div class="col-md-12">
                    <label for="file-enter-c" class="btn btn-fab btn-round btn-primary"><i class="material-icons">attach_file</i></label>
                    <input id ="file-enter-c" type="file" name="sig_id_img_three" class="inputFileHidden"/>
                    <label id="rated-c"> Select ID</label>
                    <div id="rated-c"></div>
                </div>
                <style>
            input[type="file"]{
                display: none;
            }
            .custom-file-upload{
                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
            }
            </style>
                <div class="col-md-12">
                    <label for="">Id Type</label>
                    <select  name="sig_id_card_three" class="form-control " id="">
                        <option value="National ID">National ID</option>
                        <option value="Voters ID">Voters ID</option>
                        <option value="Drivers License">Drivers license</option>
                        <option value="International Passport">International Passport</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
        ';
        echo $output1;
    }
    // Data for Joint Account
    elseif ($_POST['id'] == 'Joint') {
        // MAKING 
    }
    // Data for Individual Account
    elseif ($_POST['id'] == 'Individual' || $_POST['id'] == 'Group') {
        $output3 = '<div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label >Display name</label>
                <input  type="text"  style="text-transform: uppercase;" class="form-control" name="display_name">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >First Name <span style="color: red;">*</span></label>
                <input  type="text" style="text-transform: uppercase;" id="first" class="form-control" name="firstname" required>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >Middle Name</label>
                <input  type="text" style="text-transform: uppercase;" class="form-control" name="middlename">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >Last Name <span style="color: red;">*</span></label>
                <input  type="text" style="text-transform: uppercase;" id="last" class="form-control" name="lastname" required>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >Phone No <span style="color: red;">*</span></label>
                <input  type="number" class="form-control" id="phone" name="phone" required>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >Phone No2</label>
                <input type="number" class="form-control" name="phone2">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >Email address <span style="color: red;">*</span></label>
                <input  type="email" class="form-control" name="email" required>
            </div>
            </div>
            <div class="col-md-8">
            <div class="form-group">
                <label >Address <span style="color: red;">*</span></label>
                <input type="text" style="text-transform: uppercase;" class="form-control" name="address" required>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label >Gender:</label>
                <select  class="form-control" name="gender" id="">
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
                </select>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label class="">Date of Birth:</label>
                <input  type="date" class="form-control" id="dob" name="date_of_birth" required>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label class="">Branch:</label>
                <select class="form-control" name="branch">
                ' . branch_option($connection) . '
                </select>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label for="">Country:</label>
                <input type="text" style="text-transform: uppercase;" class="form-control" value = "NIGERIA" name="country">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
              <label for="">State:</label>
              <select id="static" class="form-control" style="text-transform: uppercase;" name="stated">
              ' . fill_state($connection) . '
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="">LGA:</label>
              <select class="form-control" name="lgka" id="showme">
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="">Occupation:</label>
                <input type="text" style="text-transform: uppercase;" class="form-control" name="occupation">
            </div>
            </div>
            <div class="col-md-4">
            <label for="">BVN:</label>
            <input type="text" required style="text-transform: uppercase;" name="bvn" class="form-control" id="bvn_check">
            <a id="bvn_on_meet" class="btn btn-primary pull-right" style="color: white">check</a>
            <span id="cbvn" style="color: green;" hidden>BVN MATCHED RECORD</span>
            <span id="wbvn" style="color: red;" hidden>WRONG BVN MATCH</span>
            <div id="bvn_result"></div>
            </div>
            <div class="col-md-4">
            <p><label for="">Active Alerts:</label></p>
            <div class="form-check form-check-inline">
            <label class="form-check-label">
                    <input class="form-check-input" name="is_staff" type="checkbox" value="1">
                    IS STAFF
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                </label>
                <label class="form-check-label">
                    <input class="form-check-input" name="sms_active" type="checkbox" value="1">
                    SMS
                    <span class="form-check-sign">
                    <span class="check"></span>
                    </span>
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" name="email_active" type="checkbox" value="">
                    Email
                    <span class="form-check-sign">
                    <span class="check"></span>
                    </span>
                </label>
            </div>
            </div>
            
            <div class="col-md-4">
            <div class="form-group">
                <label for="">Name of Next of Kin:</label>
                <input type="text"  class="form-control" name="nok">
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label for="">Relationship:</label>
                <input type="text"  class="form-control" name="relationship_Nok">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group">
                <label for="">Phone Number:</label>
                <input type="number"  class="form-control" name="numberof_Nok">
            </div>
            </div>
            <div class="col-md-2">
            <div class="form-group">
                <label for="">Email Address</label>
                <input type="number"  class="form-control" name="email_Nok">
            </div>
            </div>
          
            <style>

            .fileinput .thumbnail {
                display: inline-block;
                margin-bottom: 10px;
                overflow: hidden;
                text-align: center;
                vertical-align: middle;
                max-width: 250px;
                box-shadow: 0 10px 30px -12px rgba(0,0,0,.42), 0 4px 25px 0 rgba(0,0,0,.12), 0 8px 10px -5px rgba(0,0,0,.2);
            }
            .thumbnail {
                border: 0 none;
                border-radius: 4px;
                padding: 0;
            }
            .btn {
                  padding: 5px 5px;
            }
            .fileinput .thumbnail>img {
                max-height: 100%;
                width: 100%;
            }
            html * {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            img {
                vertical-align: middle;
                border-style: none;
            }

            </style>
                
                <div class="col-md-4">
                                <label id="upload-a"> Upload Passport</label>
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                <div>
                <button class="btn btn-primary btn-round">
                <input type="file" name="..." />
                </button>
                
                <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                </div>
                </div>
                </div>
            
            <div class="col-md-4">
            <label id="upload-a"> Upload Signature</label>
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          
                          <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                          <div>
                          <button class="btn btn-primary btn-round">
                          <input type="file" name="..." />
                          </button>
                              
                          <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                          </div>
                      </div>
            </div>
            
            <div class="col-md-4">
            <label id="upload-a"> Upload Signature</label>
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                          
                          <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                          <div>
                          <button class="btn btn-primary btn-round">
                          <input type="file" name="..." />
                          </button>
                              
                          <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                          </div>
                      </div>
            
            </div>
            <div class="col-md-4">
            
            <div class="form-group">
                <label for="">Loan Officer:</label>
                <select  name="acct_of" class="form-control" id="">
                ' . fill_officer($connection) . '
                </select>
            </div>
            </div>
            <div class="col-md-4">
            <label for="">Id Type</label>
            <select  name="id_card" class="form-control " id="">
                <option value="National ID">National ID</option>
                <option value="Voters ID">Voters ID</option>
                <option value="International Passport">International Passport</option>
                <option value="Drivers Liscense">Drivers Liscense</option>
            </select>
            </div>
            <input id="int_id" hidden value = ' . $_SESSION["int_id"] . ' hidden></input>
            <input id="branch_id" hidden value = ' . $_SESSION["branch_id"] . ' hidden></input>
            </div>';
        echo $output3;
    }


}
?>
<!-- BVN RECOROD -->
<!-- YOU WILL BE DATING DOB -->
<!-- FIRST NAME, LAST NAME, MOBLIE, BVN -->
<script>
    $(document).ready(function() {
        $('#bvn_on_meet').on("click", function(){
            var bvn = $('#bvn_check').val();
            var dob = $('#dob').val();
            var first = $('#first').val();
            var last = $('#last').val();
            var phone = $('#phone').val();
            var int_id = $('#int_id').val();
            var branch_id = $('#branch_id').val();
            // loader
            Swal({
  title: 'Processing!',
  html: 'Please Wait! <b></b> .',
  timer: 2000,
  timerProgressBar: true,
  onBeforeOpen: () => {
    Swal.showLoading()
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
    $.ajax({
                url:"ajax_post/BVN/bvn_checking.php",
                method:"POST",
            data:{bvn:bvn, dob: dob, first:first, last:last, phone:phone, int_id:int_id, branch_id:branch_id},
            success:function(data){
            $('#bvn_result').html(data);
            }
        })
  }
//   document.getElementById("dman_sub").submit();
})

            // END
    });
});
</script>
<!-- END BVN CHECK -->
<script>
    $(document).ready(function () {
        $('#static').on("change", function () {
            var id = $(this).val();
            $.ajax({
                url: "ajax_post/lga.php",
                method: "POST",
                data: {id: id},
                success: function (data) {
                    $('#showme').html(data);
                }
            })
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sig_one').on("change keyup paste", function () {
            var id = $(this).val();
            $.ajax({
                url: "ajax_post/lga.php",
                method: "POST",
                data: {id: id},
                success: function (data) {
                    $('#sigone').html(data);
                }
            })
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sig_two').on("change keyup paste", function () {
            var id = $(this).val();
            $.ajax({
                url: "ajax_post/lga.php",
                method: "POST",
                data: {id: id},
                success: function (data) {
                    $('#sigtwo').html(data);
                }
            })
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#sig_three').on("change keyup paste", function () {
            var id = $(this).val();
            $.ajax({
                url: "ajax_post/lga.php",
                method: "POST",
                data: {id: id},
                success: function (data) {
                    $('#sigthree').html(data);
                }
            })
        });
    });
</script>
<script>
    var changeq = document.getElementById('file-upload');
    var check2 = document.getElementById('upload');
    changeq.addEventListener('change', showme);

    function showme(event) {
        var one = event.srcElement;
        var fname = one.files[0].name;
        check2.textContent = 'Passport: ' + fname;
    }
</script>
<script>
    var changeq = document.getElementById('file-insert');
    var check = document.getElementById('iup');
    changeq.addEventListener('change', showme);

    function showme(event) {
        var one = event.srcElement;
        var fname = one.files[0].name;
        check.textContent = 'Signature: ' + fname;
    }
</script>
<script>
    var changeq1 = document.getElementById('file-enter');
    var check1 = document.getElementById('rated');
    changeq1.addEventListener('change', showme1);

    function showme1(event) {
        var one1 = event.srcElement;
        var fname1 = one1.files[0].name;
        check1.textContent = 'ID : ' + fname1;
    }
</script>
<script>
    var changeqa1 = document.getElementById('file-upload-a');
    var checka1 = document.getElementById('upload-a');
    changeqa1.addEventListener('change', showmea1);

    function showmea1(event) {
        var onea1 = event.srcElement;
        var fnamea1 = onea1.files[0].name;
        checka1.textContent = 'Passport: ' + fnamea1;
    }
</script>
<script>
    var changeqa2 = document.getElementById('file-insert-a');
    var checka2 = document.getElementById('iup-a');
    changeqa2.addEventListener('change', showmea2);

    function showmea2(event) {
        var onea2 = event.srcElement;
        var fnamea2 = onea2.files[0].name;
        checka2.textContent = 'Signature: ' + fnamea2;
    }
</script>
<script>
    var changeqa3 = document.getElementById('file-enter-a');
    var checka3 = document.getElementById('rated-a');
    changeqa3.addEventListener('change', showmea3);

    function showmea3(event) {
        var onea3 = event.srcElement;
        var fnamea3 = onea3.files[0].name;
        checka3.textContent = 'ID : ' + fnamea3;
    }
</script>
<script>
    var changeqb1 = document.getElementById('file-upload-b');
    var checkb1 = document.getElementById('upload-b');
    changeqb1.addEventListener('change', showmeb1);

    function showmeb1(event) {
        var oneb1 = event.srcElement;
        var fnameb1 = oneb1.files[0].name;
        checkb1.textContent = 'Passport: ' + fnameb1;
    }
</script>
<script>
    var changeqb2 = document.getElementById('file-insert-b');
    var checkb2 = document.getElementById('iup-b');
    changeqb2.addEventListener('change', showmeb2);

    function showmeb2(event) {
        var oneb2 = event.srcElement;
        var fnameb2 = oneb2.files[0].name;
        checkb2.textContent = 'Signature: ' + fnameb2;
    }
</script>
<script>
    var changeqb3 = document.getElementById('file-enter-b');
    var checkb3 = document.getElementById('rated-b');
    changeqb3.addEventListener('change', showmeb3);

    function showmeb3(event) {
        var oneb3 = event.srcElement;
        var fnameb3 = oneb3.files[0].name;
        checkb3.textContent = 'ID : ' + fnameb3;
    }
</script>
<script>
    var changeqc1 = document.getElementById('file-upload-c');
    var checkc1 = document.getElementById('upload-c');
    changeqc1.addEventListener('change', showmec1);

    function showmec1(event) {
        var onec1 = event.srcElement;
        var fnamec1 = onec1.files[0].name;
        checkc1.textContent = 'Passport: ' + fnamec1;
    }
</script>
<script>
    var changeqc2 = document.getElementById('file-insert-c');
    var checkc2 = document.getElementById('iup-c');
    changeqc2.addEventListener('change', showmec2);

    function showmec2(event) {
        var onec2 = event.srcElement;
        var fnamec2 = onec2.files[0].name;
        checkc2.textContent = 'Signature: ' + fnamec2;
    }
</script>
<script>
    var changeqc3 = document.getElementById('file-enter-c');
    var checkc3 = document.getElementById('rated-c');
    changeqc3.addEventListener('change', showmec3);

    function showmec3(event) {
        var onec3 = event.srcElement;
        var fnamec3 = onec3.files[0].name;
        checkc3.textContent = 'ID : ' + fnamec3;
    }
</script>