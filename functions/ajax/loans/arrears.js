
function arrears_ajax() {
    jQuery.ajax({
        url:'../../loans/arrears.php',
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

t = setInterval(arrears_ajax,60*60*12000);
