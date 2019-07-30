<script>
$(function () {
    $("#donator_select").hide();
  $("#role_select").change(function() {
    var val = $(this).val();
    if(val == "2") {
        $("#donator_select").show();
    }
    else {
        $("#donator_select").hide();
    }
  });
});

</script>