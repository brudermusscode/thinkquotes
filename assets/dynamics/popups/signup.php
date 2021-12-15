<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// COMMUNITY
if (isset($_POST)) {
    if (!$isLoggedIn) {

?>

        <popup-module class="login pb62">

            <label class="slideUp posrel">
                <div class="inr" style="padding:24px 42px;">
                    <p class="fs24 lt ttup mr24" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                        Sign up
                    </p>

                    <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                        <p class="posabs alignmiddle"><span class="material-icons-round md-24">close</span></p>
                    </div>

                    <div class="cl"></div>
                </div>
            </label>

            <div class="zoom-in popup-shd rd10" style="background-color:var(--colour-dark);">

                <form class="sign--form" data-form="signup">

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
                                <div class="">
                                    <input data-etat="signup:username" type="text" placeholder="Username" name="username" autocomplete="off" />
                                </div>
                            </div>

                            <div class="input posrel">
                                <div style="height:100%;width:42px;color:white;" class="posabs">
                                    <div class="alignmiddle posabs">
                                        <span class="material-icons-round md24">email</span>
                                    </div>
                                </div>
                                <div class="">
                                    <input data-etat="signup:mail" type="text" placeholder="E-Mail" name="mail" autocomplete="off" />
                                </div>
                            </div>

                            <div class="input posrel">
                                <div style="height:100%;width:42px;color:white;" class="posabs">
                                    <div class="alignmiddle posabs">
                                        <span class="material-icons-round md24">password</span>
                                    </div>
                                </div>
                                <div class="">
                                    <input data-etat="signup:password" type="password" placeholder="Password" name="password" autocomplete="off" />
                                </div>
                            </div>

                            <div class="input posrel">
                                <div style="height:100%;width:42px;color:white;" class="posabs">
                                    <div class="alignmiddle posabs">
                                        <span class="material-icons-round md24">repeat</span>
                                    </div>
                                </div>
                                <div class="">
                                    <input data-etat="signup:password2" type="password" placeholder="Type your password again..." name="password2" autocomplete="off" />
                                </div>
                            </div>

                            <div id="idcaptcha" style="padding-top:24px;">

                                <p style="color:var(--colour-light);margin-bottom:8px;">Are you a robot?</p>
                                <div class="captcha">
                                    <div class="g-recaptcha" data-sitekey="<?php echo $conf["recaptcha_publickey"]; ?>"></div>
                                    <div class="cl"></div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="submit">

                        <hellofresh data-action="function:signup" class="rdbottom8 wholebottom green">
                            <div class="c-ripple js-ripple">
                                <span class="c-ripple__circle"></span>
                            </div>
                            Sign up!
                        </hellofresh>

                    </div>

                </form>

            </div>

            <script src='https://www.google.com/recaptcha/api.js'></script>

        </popup-module>

<?php

    } else {
        exit('1');
    } // logged in
} else {
    exit('0');
} // unknown error

?>