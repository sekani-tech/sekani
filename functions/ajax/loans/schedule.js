
function schedule_ajax() {
    jQuery.ajax({
        url:'../../loans/schedule.php',
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

t = setInterval(schedule_ajax,60*60*6000);
