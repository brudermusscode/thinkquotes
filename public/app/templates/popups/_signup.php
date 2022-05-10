<?php

include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

?>

<div class="signup-container">

  <div class="cover-image" style="background:url(<?php echo $url->img; ?>/flat/meditating-girl.jpg) center no-repeat;background-size:cover;">
    <div class="cover-pulse"></div>

    <div class="breath">
      <div class="in">
        <div class="title">
          <p>breath in</p>
        </div>
      </div>
    </div>

    <div class="breath">
      <div class="out">
        <div class="title">
          <p>breath out</p>
        </div>
      </div>
    </div>

    <content-card class="signup">

      <div class="inr">

        <div class="title">
          <p>Sign up now</p>
        </div>

        <div class="input">

          <form class="sign--form" data-form="sign:up" method="POST" action>

            <div class="">
              <input data-input="sign:up,mail" type="email" name="mail" placeholder="mail@address.com" autocomplete="off" tabindex="-1" />
            </div>

          </form>
        </div>
      </div>

    </content-card>

    <content-card class="signup">
      <div class="inr">

        <div class="title">
          <p>Use your code</p>
        </div>

        <div class="input code">

          <form class="sign--form" data-form="sign:in,code" method="POST" action>
            <div class="disfl fldirrow">
              <input type="text" name="code1" autocomplete="off" tabindex="1" maxlength="1" />
              <input type="text" name="code2" autocomplete="off" tabindex="2" maxlength="1" />
              <input type="text" name="code3" autocomplete="off" tabindex="3" maxlength="1" />
              <input type="text" name="code4" autocomplete="off" tabindex="4" maxlength="1" />
            </div>

            <input type="hidden" name="uid" value />
          </form>

        </div>
      </div>
    </content-card>
  </div>

</div>

<script class="dno">
  $(function(document, window) {

    let $signupContainer, $coverPulse, $breathContainer, $signupInput, breathInterval;

    $signupContainer = $(document).find(".signup-container");
    $signupInput = $signupContainer.find('[data-input="sign:up,mail"]');
    $coverImagePulse = $signupContainer.find(".cover-image .cover-pulse");
    $breathContainer = $signupContainer.find(".breath");

    setTimeout(function() {

      // add pulsating animation to cover image cover
      $coverImagePulse.addClass("pulsating");

      //show breath in container
      $breathContainer.find(".in").parent().addClass("visible");

      // set interval for two bearths in and out
      let breathInterval = setInterval(function() {
        $breathContainer.toggleClass("visible");
      }, 6000);

      // set timeout for clearing the interval of breathing
      // and show the sign up container
      setTimeout(function() {

        // focus email input
        setTimeout(function() {

          $signupInput.focus();
        }, 10);

        // clear the interval
        clearInterval(breathInterval);

        // hide breath texts
        $breathContainer.removeClass("visible");

        // show sign up container
        $signupContainer.find("content-card").first().addClass("visible");
      }, 24000);
    }, 1200);
  });
</script>