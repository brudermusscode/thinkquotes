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

        $(document).on("submit", '[data-form="sign:in"], [data-form="sign:in,code"]', function() {

            // get correct url for each case of sign up...
            if ($(this).data("form") == "sign:in") {

                url = dynamicHost + "/dyn/sign/in";
            } else {

                // and passing a authentication code
                url = dynamicHost + "/dyn/sign/code";
            }

            // get formdata
            formData = new FormData(this);

            // choose current content-card
            $contentCard = $(this).closest("content-card");

            // with that content-card chosen, choose the next sibling
            $nextSibling = $contentCard.next();

            $.ajax({

                url: url,
                data: formData,
                method: $(this).attr("method"),
                dataType: "JSON",
                contentType: false,
                processData: false,
                success: function(data) {

                    if (data.status) {

                        // toggle class visible for both content card, so 
                        // passing code will be made possible
                        $contentCard.toggleClass("visible");
                        $nextSibling.toggleClass("visible");

                        // find uid input and set it
                        $nextSibling.find("input[name='uid']").val(data.uid);

                        // why so ever, but focus on the first code input
                        // after timeout of 100 ms
                        setTimeout(function() {
                            $nextSibling.find("input[name='code1']").focus();
                        }, 100);
                    }

                    // show responsive error module with error text
                    showErrorModule(data.message);
                },
                error: function(data) {
                    console.error(data);
                }
            });

        });


        // go to next input if maxlength is reached
        $(document).on("input", "input", function() {

            if (this.hasAttribute("maxlength")) {

                $t = $(this);
                value = this.value;
                $nextSibling = $t.next();
                $previousSibling = $t.prev();
                $lastSibling = $t.parent().find("input").last();
                let maxLength = this.getAttribute("maxlength");

                // if the maxlength of the input is reached, ...
                if (value.length >= maxLength) {

                    // ... focus the enxt sibling
                    $nextSibling.focus();

                    // if we reached the last element of the code input
                    // chain, submit the form and check, if the code is valid
                    if ($lastSibling.attr("maxlength") == $lastSibling.val().length) {
                        $t.closest("form").submit();
                    }

                    // if input is empty, change to previous sibling
                } else if (value.length == 0) {
                    $previousSibling.focus();
                }
            }

            return false;
        });
    });
</script>