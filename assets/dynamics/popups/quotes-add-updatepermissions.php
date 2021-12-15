<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if ($isLoggedIn) {

?>



    <popup-module class="large mt42 pb62" style="z-index:10000000;">

        <div class="zoom-in popup-shd rd10" style="background-color:var(--colour-dark);">

            <div class="inr mshd-1 posrel" style="z-index:1;color:var(--colour-light);padding:62px;">

                <div class="spin-cubic-endless posrel" style="color:var(--colour-green);height:60px;width:60px;margin:42px auto;">
                    <div class="" style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);">
                        <span class="material-icons-round md-82">verified</span>
                    </div>
                </div>

                <p style="color:var(--colour-light);font-size:2em;" class="tac mb24">Thank you!</p>
                <div>
                    <p class="tac">Since you've added 3 quotes now and none of them are atleast upvoted for 20 times, we have limited your ability to add content to this side. As soon as one of your quote fulfills the 20 upvote limitation, you will be able to limitless post anything to this side!</p>
                </div>

            </div>

            <div class="submit">

                <hellofresh data-action="function:overlay,close" onclick="closeOverlay();" class="rdbottom8 wholebottom green">
                    <div class="c-ripple js-ripple">
                        <span class="c-ripple__circle"></span>
                    </div>
                    Alright, thank you!
                </hellofresh>

            </div>

        </div>

    </popup-module>


<?php

} else {
    exit('0');
}

?>