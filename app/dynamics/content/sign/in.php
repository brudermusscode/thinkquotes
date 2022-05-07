<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php"; ?>

<div class="signup-container">

    <div class="cover-image" style="background:url(<?php echo $url->img; ?>/flat/5184247.jpg) center no-repeat;background-size:cover;">
        <div class="cover-pulse"></div>

        <content-card class="signup">

            <div class="inr">

                <div class="title">
                    <p>Sign in with your account</p>
                </div>

                <div class="input">

                    <form class="sign--form" data-form="sign:in" method="POST" action>

                        <div class="">
                            <input type="text" name="mail" placeholder="mail@address.com" autocomplete="off" tabindex="1" autofocus />
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
    $(function() {

        let $signupContainer, $coverPulse, $breathContainer, $signupInput, breathInterval, url, formData, $nextSibling, $contentCard;

        $signupContainer = $(document).find(".signup-container");
        $coverImagePulse = $signupContainer.find(".cover-image .cover-pulse");
        $breathContainer = $signupContainer.find(".breath");

        // get sign in form
        $signupContainer.find('[data-form="sign:in,code"]');

        setTimeout(function() {

            // add pulsating animation to cover image cover
            $coverImagePulse.addClass("pulsating");

            // show sign up container
            $signupContainer.find("content-card").first().addClass("visible");

            setTimeout(function() {
                $signupContainer.find("content-card").first().find("input[name='mail']").focus();
            }, 100);
        }, 400);
    });
</script>