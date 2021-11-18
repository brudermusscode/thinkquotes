<?php

$is_page = true;
$page = "intern";

// mysql database
require_once "../session/session.inc.php";

// Head section
include_once "../assets/templates/global/head.php";
include_once "../assets/templates/global/header.php";

?>


<div id="main" class="wpx--main">

    <div class="pb32" style="margin:20px auto 0;width: calc(100% - 48px);max-width: 1230px;color: var(--colour-light);font-size: 2em;font-weight: 400;text-shadow: 0 1px 2px rgba(0, 0, 0, 0.24);">
        <p class="tac">How to help you?</p>
    </div>

    <div class="intern--outer">

        <!-- privacy policies -->
        <a href="<?php echo $main["internurl"]; ?>/privacy">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/07.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/07.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-red);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">fingerprint</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">Data, Cookies &amp; more</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Privacy Policies</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- imprint -->
        <a href="<?php echo $main["internurl"]; ?>/imprint">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/28.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/28.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-green);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">fact_check</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">All about us</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Imprint</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>


        <!-- disclaimer -->
        <a href="<?php echo $main["internurl"]; ?>/imprint#disclaimer">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/30.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/30.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-blue);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">gavel</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">Copyright stuff</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Disclaimer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- updates -->
        <a href="<?php echo $main["internurl"]; ?>/updates">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/01.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/01.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-lila);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">restore</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">What's new?</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Updates</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <div class="cl"></div>

        <div style="width:2.6em;margin:42px auto;">
            <span style="color:white;text-shadow: 0 1px 2px rgba(0 0 0 / 24%);" class="material-icons-round md-42">keyboard_arrow_down</span>
        </div>

        <div class="section-label">
            <p>Interesting</p>
        </div>


        <!-- team -->
        <a href="<?php echo $main["internurl"]; ?>/team">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/31.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/31.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-darkred);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">supervised_user_circle</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">We got you</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Dev-Team</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- partners -->
        <a href="<?php echo $main["internurl"]; ?>/partners">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/102.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/102.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-pink);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">recent_actors</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">Sites we trust</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Partners</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        </a>

        <!-- sources -->
        <a href="<?php echo $main["internurl"]; ?>/sources">
            <div class="element">
                <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/intern/400/103.png) top right / cover no-repeat;">
                    <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/intern/400/103.png">
                </div>

                <div class="ud-inr">
                    <div class="inr-outer">
                        <div class="tar">
                            <p class="tac rd6" style="background:var(--colour-bluegrey);position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                <i class="material-icons-round md-24 align-mid-vert">source</i>
                            </p>

                            <div class="cl"></div>

                            <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;">Graphics, texts, etc.</p>
                                <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;">Sources</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <div class="cl"></div>

    </div>

</div>


<?php

// foot section
include_once "../assets/templates/global/footer.php";

?>