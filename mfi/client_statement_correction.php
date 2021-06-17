<?php
$page_title = "Client Statement Correction";
$destination = "";
include("header.php");

?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Client Statement Corrections</h4>
                        <p class="category">Deleting Wrongly Inputed Transactions</p>
                    </div>
                    <div class="card-body">
                        <!-- <form action="" method="POST"> -->
                            <div class="row">
                                
                                    <script>
                                        $(document).ready(function() {
                                            $('#act').on("change keyup paste", function() {
                                                var id = $(this).val();
                                                var ist = $('#int_id').val();
                                                $.ajax({
                                                    url: "acct_name.php",
                                                    method: "POST",
                                                    data: {
                                                        id: id,
                                                        ist: ist
                                                    },
                                                    success: function(data) {
                                                      $('#accname').html(data);
                                                   }
                                                })
                                            });
                                        });
                                    </script>
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Number<span style="color: red;">*</span>:</label>
                                                <input type="text" class="form-control" name="account_no" id="act" required>
                                                <input type="text" class="form-control" hidden name="" value="<?php echo $sessint_id; ?>" id="int_id">
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="accname"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <div class="form-group"> -->
                                            <!-- <label><span style="color: red;"></span></label><br> -->
                                            <button type="button" name="display" id ="display" class="btn btn-primary btn-round">Show Statement</button>
                                        <!-- </div> -->
                                        <!-- <div class="form-group"> -->
                                            <!-- <label><span style="color: red;"></span></label><br> -->
                                            <button type="button" name="correctFlow" id ="correctFlow" class="btn btn-primary btn-round">Correct Statement</button>
                                        <!-- </div> -->
                                    </div>
                                
                                </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Client Statement</h4>
                    <p class="category">Review the generated Statement and Delete as Needed</p>
                </div>
                <div class="card-body">

                    <div class="row mt-4">
                        <div class="col-md-12">
                        
                            <table id="dope" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Value Date</th>
                                        <th>Reference</th>
                                        <th>Debits(&#8358;)</th>
                                        <th>Credits(&#8358;)</th>
                                        <th>Balance(&#8358;)</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody id="showStatement">
                                
                                </tbody>


                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

        

        <script>
            $(document).ready(function() {
                $('#display').on("click", function() {
                    var account_no = $('#account_no').val();
                    // var end = $('#end').val();
                    var int_id = $('#int_id').val();

                    $.ajax({
                        url: "ajax_post/support/account_statement.php",
                        method: "POST",
                        data: {
                            account_no: account_no,
                            // end: end,
                            int_id: int_id
                        },
                        success: function(data) {
                            $('#showStatement').html(data);
                        }
                    })
                });
                $('#correctFlow').on("click", function() {
                    var account_no = $('#account_no').val();
                    // var end = $('#end').val();
                    var int_id = $('#int_id').val();

                    $.ajax({
                        url: "ajax_post/support/correct_statement.php",
                        method: "POST",
                        data: {
                            account_no: account_no,
                            // end: end,
                            int_id: int_id
                        },
                        success: function(data) {
                            $('#showStatement').html(data);
                        }
                    })
                });
                $('#dope').DataTable({
                    serverSide: true,
                    // ajax: 'ajax_post/support/account_statement.php'
                });
            });
            
        </script>


    </div>

</div>
<!-- <script>
   $(document).ready(function() {
      $('#eodr').DataTable();
   });
</script> -->

<?php
include("footer.php");
?>