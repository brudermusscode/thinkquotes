<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php"; ?>

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

        <div class="signup">

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

        </div>
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
                // ! TODO: doesnt work, why so ever. Fix it later
                $signupInput.focus();

                // clear the interval
                clearInterval(breathInterval);

                // hide breath texts
                $breathContainer.removeClass("visible");

                // show sign up container
                $signupContainer.find(".signup").addClass("visible");
            }, 23000);
        }, 1200);
    });
</script>