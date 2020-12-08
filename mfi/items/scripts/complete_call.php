<!-- autocomplete -->
<script src="../functions/autocomplete/autocomplete.js"></script>
    <link href="../functions/autocomplete/autocomplete.css" rel="stylesheet">
    <?php

    if ($page_title == "Deposit/ Withdrawal") {

    ?>
        <script>
            window.addEventListener("load", function() {
                suggest.attach({
                    target: "actName",
                    url: "../functions/autocomplete/autosearch.php",
                    data: {
                        type: "name"
                    },
                    // delay : 200,
                    min: 1
                });

            });
            $(document).ready(function() {
                $('.actName').on("change keyup paste", function() {
                    var name = $(this).val();
                    var ist = $('#int_id').val();
                    $.ajax({
                        url: "acct_acctName.php",
                        method: "POST",
                        data: {
                            name: name,
                            ist: ist
                        },
                        success: function(data) {
                            $('#accname').html(data);
                        }
                    })
                });
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            // var $j = jQuery.noConflict();
            window.addEventListener("load", function() {
                suggest.attach({
                    method: "POST",
                    target: "groups",
                    url: "../functions/autocomplete/autosearch2.php",
                    data: {
                        type: "groups"
                    },
                    // delay : 200,
                    min: 1
                });

            });
        </script>
    <?php
    }
    ?>