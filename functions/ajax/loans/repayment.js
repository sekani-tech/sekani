
function repayment_ajax() {
    jQuery.ajax({
        url:'../../loans/repayment.php',
        type:'POST',
        success:function(results) {
            alert("done");
            jQuery(".result").html(results);

        },
        error: function() {
            alert("Error occured.please try again");
            
        }
    });
}

t = setInterval(repayment_ajax,60*60*12000);
