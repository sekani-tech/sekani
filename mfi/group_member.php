<?php
$page_title = "Group Loan";
include("header.php");
?>

<div class="content">
    <div class="container-fluid">
        <!-- your content here -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header-primary">
                        <h4 class="card-title">Regular header</h4>
                        <p class="category">Category subtitle</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Client Role</label>
                                    <select name="client_id" class="form-control" id="">
                                        <option value="">Member</option>
                                        <option value="">Secretary</option>
                                        <option value="">Leader</option>
                                        <option value="">Treasurer</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">First Name</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="col">
                                            <label class="">Middle Name</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="col">
                                            <label class="">Last Name</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col">
                                        <label class="">Registration Date</label>
                                        <input type="date" class="form-control" id="" name="Registration Date">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Phone Number</label>
                                            <input type="number" class="form-control" placeholder="">
                                        </div>
                                        <div class="col">
                                            <label class="">Secondary Number</label>
                                            <input type="number" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Email Address</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Date of Birth:</label>
                                            <input type="date" class="form-control" id="dob" name="date_of_birth">
                                        </div>
                                        <div class="col">
                                            <label class="bmd-label-floating">Gender</label>
                                            <select name="client_id" class="form-control" id="">
                                                <option value="">Male</option>
                                                <option value="">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>





                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Tags">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Address</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                        <div class="col">
                                            <label class="">State</label>
                                            <select id="static" class="form-control" style="text-transform: uppercase;" name="stated">
                                                <option value="Abia State">Abia State</option>
                                                <option value="Adamawa State">Adamawa State</option>
                                                <option value="Akwa Ibom State">Akwa Ibom State</option>
                                                <option value="Anambra State">Anambra State</option>
                                                <option value="Bauchi State">Bauchi State</option>
                                                <option value="Bayelsa State">Bayelsa State</option>
                                                <option value="Benue State">Benue State</option>
                                                <option value="Borno State">Borno State</option>
                                                <option value="Cross River State">Cross River State</option>
                                                <option value="Delta State">Delta State</option>
                                                <option value="Ebonyi State">Ebonyi State</option>
                                                <option value="Edo State">Edo State</option>
                                                <option value="Ekiti State">Ekiti State</option>
                                                <option value="Enugu State">Enugu State</option>
                                                <option value="FCT">FCT</option>
                                                <option value="Gombe State">Gombe State</option>
                                                <option value="Imo State">Imo State</option>
                                                <option value="Jigawa State">Jigawa State</option>
                                                <option value="Kaduna State">Kaduna State</option>
                                                <option value="Kano State">Kano State</option>
                                                <option value="Katsina State">Katsina State</option>
                                                <option value="Kebbi State">Kebbi State</option>
                                                <option value="Kogi State">Kogi State</option>
                                                <option value="Kwara State">Kwara State</option>
                                                <option value="Lagos State">Lagos State</option>
                                                <option value="Nasarawa State">Nasarawa State</option>
                                                <option value="Niger State">Niger State</option>
                                                <option value="Ogun State">Ogun State</option>
                                                <option value="Ondo State">Ondo State</option>
                                                <option value="Osun State">Osun State</option>
                                                <option value="Oyo State">Oyo State</option>
                                                <option value="Plateau State">Plateau State</option>
                                                <option value="Rivers State">Rivers State</option>
                                                <option value="Sokoto State">Sokoto State</option>
                                                <option value="Taraba State">Taraba State</option>
                                                <option value="Yobe State">Yobe State</option>
                                                <option value="Zamfara State">Zamfara State</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="">LGA</label>
                                            <select class="form-control" name="lgka" id="showme">
                                                <option value="">Option</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="">City</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="row">
                                        <div class="col">
                                            <label class="bmd-label-floating">Marital Status</label>
                                            <select name="client_id" class="form-control" id="">
                                                <option value="">Single</option>
                                                <option value="">Married</option>
                                                <option value="">Divorce</option>
                                                <option value="">Widow</option>
                                                <option value="">Widower</option>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Employment Status</label>
                                                <select name="client_id" class="form-control" id="">
                                                    <option value="">Employed</option>
                                                    <option value="">Unemployed</option>
                                                    <option value="">Self-Employed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>



                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Business Name</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Business Start Date</label>
                                            <input type="date" class="form-control" id="dob" name="Business_start_Date">
                                        </div>

                                        <div class="col">
                                            <label class="bmd-label-floating">Nature of Business</label>
                                            <select name="" class="form-control" id="">
                                                <option value="">Select Option</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Business Address</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                        <div class="col">
                                            <label class="">Business City</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                        <div class="col">
                                            <label class="bmd-label-floating">Country</label>
                                            <select name="client_id" class="form-control" id="">
                                                <option value="Afganistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bonaire">Bonaire</option>
                                                <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Canary Islands">Canary Islands</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Channel Islands">Channel Islands</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos Island">Cocos Island</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote DIvoire">Cote DIvoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Curaco">Curacao</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Ter">French Southern Ter</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Great Britain">Great Britain</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Hawaii">Hawaii</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="India">India</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea Sout">Korea South</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Midway Islands">Midway Islands</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Nambia">Nambia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                <option value="Nevis">Nevis</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau Island">Palau Island</option>
                                                <option value="Palestine">Palestine</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Phillipines">Philippines</option>
                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Barthelemy">St Barthelemy</option>
                                                <option value="St Eustatius">St Eustatius</option>
                                                <option value="St Helena">St Helena</option>
                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="St Maarten">St Maarten</option>
                                                <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                <option value="Saipan">Saipan</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="Samoa American">Samoa American</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Tahiti">Tahiti</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uraguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State">Vatican City State</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                <option value="Wake Island">Wake Island</option>
                                                <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="">Nature of Project</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>

                                        <div class="col">
                                            <label class="">Duration of Project</label>
                                            <input type="text" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Loan Officer:</label>
                                            <select name="acct_of" class="form-control" id="">
                                                <option value="65">ABIGAIL Thaddeus</option>
                                                <option value="2">Akande, Mosi</option>
                                                <option value="96">AKPA IFEANYI CHUKWU</option>
                                                <option value="68">AKUNNA EGWUATU</option>
                                                <option value="6">Eneh, Grace </option>
                                                <option value="7">Ibekwe, Faith</option>
                                                <option value="95">IGBOKWE KELECHI</option>
                                                <option value="113">it-support</option>
                                                <option value="107">it-support5</option>
                                                <option value="92">johnson anita</option>
                                                <option value="222">Nwaose Benedicta</option>
                                                <option value="60">Osareme Solomon</option>
                                                <option value="223">ruso</option>
                                                <option value="53">samm</option>
                                                <option value="52">Tech Support DG</option>
                                                <option value="67">THERESA ITODO</option>
                                                <option value="5">Umogbai Favour</option>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label for="">Id Type</label>
                                            <select name="id_card" class="form-control " id="">
                                                <option value="National ID">National ID</option>
                                                <option value="Voters ID">Voters ID</option>
                                                <option value="International Passport">International Passport</option>
                                                <option value="Drivers Liscense">Drivers Liscense</option>
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label class="">BVN</label>
                                            <input type="number" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>



                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-md-4">
                                        <label id="upload-a"> Upload Passport</label>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                            <div>
                                                <button class="btn btn-primary btn-round">
                                                    <input type="file" name="...">
                                                </button>

                                                <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="upload-a"> Upload Passport</label>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                            <div>
                                                <button class="btn btn-primary btn-round">
                                                    <input type="file" name="...">
                                                </button>

                                                <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="upload-a"> Upload Passport</label>
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                            <div>
                                                <button class="btn btn-primary btn-round">
                                                    <input type="file" name="...">
                                                </button>

                                                <a href="#pablo" class="btn btn-danger btn-fab btn-fab-mini btn-round fileinput-exists" data-dismiss="fileinput"> <i class="material-icons">clear</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>




    <?php
    include('footer.php');
    ?>