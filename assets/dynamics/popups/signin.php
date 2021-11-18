<?php

include_once './../../../session/session.inc.php';

// COMMUNITY
if (isset($_POST)) {
    if (!$isLoggedIn) {

?>

        <popup-module class="login pb62">

            <label class="slideUp posrel">
                <div class="inr" style="padding:24px 42px;">
                    <p class="fs24 lt ttup mr24" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                        Login
                    </p>

                    <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                        <p class="posabs alignmiddle"><span class="material-icons-round md-24">close</span></p>
                    </div>

                    <div class="cl"></div>
                </div>
            </label>

            <div class="zoom-in popup-shd rd10" style="background-color:var(--colour-dark);">

                <form class="sign--form" data-form="login">

                    <div class="inr mshd-1 posrel" style="z-index:1;">

                        <!-- <div class="rd8 mt12 mb32 posrel" style="background:var(--colour-red);padding:12px 18px;color:var(--colour-light);">
                            <p class="fw1 lt w12" style="font-size:.8em;"><span class="material-icons-round md-24">report_problem</span></p>
                            <p class="fw1 rt w86" style="font-size:.8em;line-height:1.4;">This website still is in development, so not everything might work as expected. But we thank you for trying out!</p>
                            <div class="cl"></div>
                        </div> -->

                        <div>

                            <div class="input posrel">
                                <div style="height:100%;width:42px;color:white;" class="posabs">
                                    <div class="alignmiddle posabs">
                                        <span class="material-icons-round md24">insert_emoticon</span>
                                    </div>
                                </div>
                                <div class="w100">
                                    <input class="w100" value="" data-etat="login:username" type="text" placeholder="Username/E-Mail" name="username" autocomplete="off" />
                                </div>
                            </div>

                            <div class="input posrel">
                                <div style="height:100%;width:42px;color:white;" class="posabs">
                                    <div class="alignmiddle posabs">
                                        <span class="material-icons-round md24">password</span>
                                    </div>
                                </div>
                                <div class="">
                                    <input value="" data-etat="login:password" type="password" placeholder="Password" name="password" autocomplete="off" />
                                </div>
                            </div>

                            <div class="mt24">
                                <p class="isDark tar">No account yet? <a class="rt ml4" style="cursor:pointer;" onclick="closeOverlay();" data-action="popup:signup">Sign up here!</a></p>
                            </div>
                        </div>

                    </div>

                    <div class="submit">

                        <hellofresh data-action="function:login" class="rdbottom8 wholebottom green">
                            <div class="c-ripple js-ripple">
                                <span class="c-ripple__circle"></span>
                            </div>
                            Check login
                        </hellofresh>

                    </div>

                </form>

            </div>

        </popup-module>

<?php

    } else {
        exit('1');
    }
} else {
    exit('0');
}

?>