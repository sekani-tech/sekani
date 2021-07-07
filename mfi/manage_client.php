<?php

$page_title = "New Client";
$destination = "client.php";
include('header.php');
function fill_savings($connection)
{
    $sint_id = $_SESSION["int_id"];
    return selectAll('savings_product', ['int_id' => $sint_id]);
}

if ($acc_op == 1 || $acc_op == "1") {
?>
    <!-- Content added here -->
    <div class="content">
        <div class="container-fluid">
            <!-- your content here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Create new Client</h4>
                            <p class="card-category">Fill in all important data</p>
                        </div>
                        <div class="card-body">
                            <form action="../functions/institution_client_upload.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Type</label>
                                            <select required name="acct_type" class="form-control" data-style="btn btn-link" id="collat">
                                                <option value="">select a Account Type</option>
                                                <?php $results = fill_savings($connection);
                                                foreach ($results as $result) { ?>
                                                    <option value="<?php echo $result["id"]; ?>"><?php echo $result["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Client Type</label>
                                            <select required name="ctype" class="form-control" id="tom">
                                                <option value="">select</option>
                                                <option value="Individual">Individual Account</option>
                                                <option value="Joint">Joint Account</option>
                                                <option value="Corporate">Corporate Account</option>
                                                <option value="Group">Group Account</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <script>
                                        $(document).ready(function() {

                                        });
                                    </script> -->
                                    <div id="client">
                                    </div>

                                </div>
                                <a href="client.php" class="btn btn-danger">Back</a>
                                <input type="submit" value="Create Client" name="submit" id="submit" disabled class="btn btn-primary pull-right" />
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /form card -->
            </div>
            <!-- /content -->
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#tom').on("change", function() {
                var id = $(this).val();
                $.ajax({
                    url: "ajax_post/client_type.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#client').html(data);
                    }
                })
            });
            $('#bvn_on_meet').on("click", function() {
                console.log('BVN received')
                alert("BVN received");
                var bvn = $('#bvn_check').val();
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
                            url: "ajax_post/BVN/bvn_checking.php",
                            method: "POST",
                            data: {
                                bvn: bvn,
                                int_id: int_id,
                                branch_id: branch_id
                            },
                            success: function(data) {
                                $('#bvn_result').html(data);
                            }
                        })
                    }
                    //   document.getElementById("dman_sub").submit();
                })

                // END
            });
            $('#static').on("change", function() {
                var id = $(this).val();
                $.ajax({
                    url: "ajax_post/lga.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#showme').html(data);
                    }
                })
            });
            $('#sig_one').on("change keyup paste", function() {
                var id = $(this).val();
                $.ajax({
                    url: "ajax_post/lga.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#sigone').html(data);
                    }
                })
            });
            $('#sig_two').on("change keyup paste", function() {
                var id = $(this).val();
                $.ajax({
                    url: "ajax_post/lga.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#sigtwo').html(data);
                    }
                })
            });
            $('#sig_three').on("change keyup paste", function() {
                var id = $(this).val();
                $.ajax({
                    url: "ajax_post/lga.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#sigthree').html(data);
                    }
                })
            });
        });
    </script>
<?php
} else {
    echo '<script type="text/javascript">
  $(document).ready(function(){
   swal({
    type: "error",
    title: "Account opening Authorization",
    text: "You Dont Have permission open an account",
   showConfirmButton: false,
    timer: 2000
    }).then(
    function (result) {
      history.go(-1);
    }
    )
    });
   </script>
  ';
    // $URL="transact.php";
    // echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>
<?php

include("footer.php");

?>