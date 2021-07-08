<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">
</script>


<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>input</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">Total</td>
            <td>
                <input type="number" class="grand_total" name="total" readonly>
            </td>
        </tr>
        <tr class="">
            <td>1</td>
            <td>Tunde</td>
            <td>
                <input type="number" name="amount" class="total_price">
            </td>
        </tr>
        <tr class="">
            <td>2</td>
            <td>Tunde</td>
            <td>
                <input type="number" name="amount2" class="total_price">
            </td>
        </tr>
    </tbody>
</table>

<script>
    $(document).ready(function() {
  $("body").on("keyup", "input", function(event){
    $(this).closest(".line").find(".total_price").val( $(this).closest(".line").val()*1-$(this).closest(".line").val() );
    var sum = 0;
    $('.total_price').each(function() {
        sum += Number($(this).val());
    });
    $(".grand_total").val(sum);
  });
});
</script>