<script>
$(function () {
    $("#org_select").hide();
  $("#role_select").change(function() {
    var val = $(this).val();
    if(val == "3") {
        $("#org_select").show();
    }
    else {
        $("#org_select").hide();
    }
  });
});

</script>