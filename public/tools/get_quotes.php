<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

$is_page = true;
$page = "tools/get_quotes";

include_once TEMPLATES . "/global/head.php";

?>

<div class="alignmiddle posabs">

  <div class="tac mb32">
    <p style="color:white;">Download quotes</p>
  </div>

  <div class="disfl fldirrow flCenter">
    <hellofresh data-action="tools,get_quotes" class="hellofresh hover-shadow shadowed red rounded icon-only">
      <div class="c-ripple js-ripple">
        <span class="c-ripple__circle"></span>
      </div>
      <p class="lt posabs alignmiddle">
        <i class="ri-download-fill"></i>
      </p>

      <div class="cl"></div>
    </hellofresh>
  </div>
</div>

<script>
jQuery(function() {
  $(document).on('click', '[data-action="tools,get_quotes"]', function() {

    let $t = $(this);

    $.ajax({
      url: dynamicHost + '/do/tools/get_quotes',
      data: {
        getQuotes: null
      },
      dataType: 'JSON',
      method: 'POST',
      beforeSend: () => {
        showErrorModule("Getting quotes...");
      },
      success: (data) => {
        console.log(data);
        showErrorModule(data.message);
      },
      error: (data) => {
        console.error(data);
      }
    });

  });
});
</script>