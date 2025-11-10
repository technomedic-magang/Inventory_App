<script>
  function search_module(obj) {
    $.post(
      '<?= $this->uri . '/ajax/module?n=' . $this->nav_id ?>', {
        term: obj.value
      },
      function(resp) {
        $("#module").html(resp.html);
      }, "json"
    )
    console.log(obj.value);
  }
</script>