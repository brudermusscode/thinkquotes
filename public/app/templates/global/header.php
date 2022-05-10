<?php

if (!$is_page) {
    header("location: /");
}

if (LOGGED) {

    // check for friendrequests
    $hasFriendsRequests = $friends->getFriendrequests($my->uid);

    // get count of friendrequests
    $frcount = $hasFriendsRequests;
}

?>

<header id="main-hdr" class="posrel">

    <script>
        $(document).ready(function() {

            $(document).on("click", '[data-structure="header:base-menu"] .bm', function() {

                var thisbm = $(this).find('p');
                var eachbm = $('[data-structure="header:base-menu"] .bm').find('p');

                eachbm.removeClass('active');
                thisbm.addClass('active');

            });

        });
    </script>

    <div class="inr wpx--main posrel">

        <div class="middle-logo--outer posabs alignmiddle" style="z-index:100;">

            <?php if (LOGGED) { ?>

                <pulse class="roundedPulse small"></pulse>

                <hellofresh <?php if ($my->post_permissions == "none") { ?>disabled="true" <?php } ?> data-action="popup:quotes,add" class="hellofresh hover-shadow shadowed red rounded icon-only">
                    <div class="c-ripple js-ripple">
                        <span class="c-ripple__circle"></span>
                    </div>
                    <p class="lt posabs alignmiddle">
                        <i class="ri-add-line std"></i>
                    </p>

                    <div class="cl"></div>
                </hellofresh>

            <?php } else { ?>

                <div class="lo-sizing">
                    <div class="logo" style="background: transparent url(<?php echo $url->img; ?>/global/newlogo.2.png) center no-repeat;background-size: cover;">
                        <img src="<?php echo $url->img; ?>/global/newlogo.2.png" style="visibility:hidden;opacity:0;">
                    </div>
                </div>

            <?php } ?>

        </div>

        <div class="lt-content">
            <div data-structure="header:base-menu" class="base-menu disfl fldirrow">

                <div class="bm single rounded <?php if ($page === "index") {
                                                    echo "active";
                                                } ?>" onclick="window.location.replace('<?php echo $url->main; ?>');">
                    <p>
                        <i class="ri-layout-masonry-fill std"></i>
                    </p>
                </div>

                <div class="bm single rounded <?php if ($page === "intern") {
                                                    echo "active";
                                                } ?>" onclick="window.location.replace('<?php echo $url->intern; ?>');">
                    <p>
                        <i class="material-icons std">explore</i>
                    </p>
                </div>

                <div class="bm single rounded" onclick="window.open('https://www.github.com/brudermusscode/thinkquotes');">
                    <p>
                        <i class="ri-github-fill std"></i>
                    </p>
                </div>

            </div>
        </div>

        <div class="rt-content">

            <div class="disfl fldirrow rt">

                <?php

                if (LOGGED) {

                    include_once TEMPLATES . "/global/_usermenu.php";
                } else { ?>

                    <hellofresh data-action="popup:login" class="hellofresh rd6 big mr12 hover-shadow" style="color:var(--colour-light);">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        Log in
                    </hellofresh>

                    <hellofresh data-action="popup:signup" class="rd6 big red hover-shadow">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        Join
                    </hellofresh>

                <?php } ?>


            </div>

            <div class="cl"></div>
        </div>

        <div class="cl"></div>
    </div>

</header>

<?php if ($page === "intern") { ?>
    <div style="height:190px;"></div>
<?php } else { ?>
    <div style="height:150px;"></div>
<?php } ?>

<?php if ($page === "intern") { ?>
    <header id="intern-hdr"></header>
<?php } ?>