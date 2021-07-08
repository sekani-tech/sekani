
function payment_ajax() {
    jQuery.ajax({
        url:'../../loans/payment.php',
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

t = setInterval(payment_ajax,60*60*12000);
