<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if ($isLoggedIn) {

?>



    <popup-module class="pb62" style="max-width:360px;z-index:10;">

        <form data-form="sign:out">

            <div class="slideUp mshd-4 rd10" style="background-color:var(--colour-dark);">

                <label class="posrel">
                    <div class="inr" style="padding:24px 42px;">
                        <p class="fs24 lt ttup mr24 pt2" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                            Logout
                        </p>

                        <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                            <p class="posabs alignmiddle"><span class="material-icons-round md24">close</span></p>
                        </div>

                        <div class="cl"></div>
                    </div>
                </label>

                <div class="inr mshd-1 posrel" style="z-index:1;padding:24px 48px 48px;">
                    <p class="posabs align-mid-horiz" style="color:var(--colour-light);">
                        <span class="material-icons-round md-62">contact_support</span>
                    </p>
                    <p class="tac mt72" style="color:var(--colour-light);margin-bottom:8px;">You want to go already?</p>
                </div>

                <div class="submit">

                    <hellofresh data-action="function:sign,out" class="rdbottom8 wholebottom darkred">
                        Yes, let me go!
                    </hellofresh>

                </div>

            </div>

        </form>

    </popup-module>


<?php

} else {
    exit('0');
}

?>