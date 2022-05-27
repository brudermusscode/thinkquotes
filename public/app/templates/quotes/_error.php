<popup-module>

  <div class="inr">

    <div style="height:20em;width:20em;background:url(<?php echo IMAGES . "/flat/11098.jpg"; ?>) center bottom no-repeat;background-size:cover;border-radius:50%;" class="mb32 disn"></div>

    <label for="popup-module" class="mb32">
      <div class="label-inr light p32">
        <p style=font-size:2em;line-height:1em;letter-spacing:-.04em;>Ruhm liegt nicht darin, niemals zu fallen, sondern jedes Mal wieder aufzustehen, wenn wir gescheitert sind.</p>
        <p style=text-align:right;font-size:1.8em;margin-top:1em;opacity:.8;><i>Konfuzius</i></p>
      </div>
    </label>
  </div>

</popup-module>

<script class="dno">
  $(() => {
    setTimeout(() => {

      let $popupModule = $(document).find("popup-module");

      $popupModule.addClass("active");
    }, 750);
  });
</script>