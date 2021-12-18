<?php

if (!$is_page) {
    header("location: /");
}

if (LOGGED) {

    // check for friendrequests
    $hasFriendsRequests = $friends->getFriendrequests(UID);

    // get count of friendrequests
    $frcount = $hasFriendsRequests;
}

//var_dump($_SESSION);
//unset($_SESSION);
//session_destroy();

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

        <div class="middle-logo--outer posabs alignmiddle">
            <div class="lo-sizing">
                <div class="logo" style="background: transparent url(<?php echo $url->img; ?>/global/newlogo.2.png) center no-repeat;background-size: cover;">
                    <img src="<?php echo $url->img; ?>/global/newlogo.2.png" style="visibility:hidden;opacity:0;">
                </div>
            </div>
        </div>

        <div class="lt-content">
            <div data-structure="header:base-menu" class="base-menu disfl fldirrow">
                <div class="bm single rd6 <?php if ($page === "index") {
                                                echo "active";
                                            } ?>" onclick="window.location.replace('<?php echo $url->main; ?>');">
                    <p>
                        <i class="ri-layout-masonry-fill std"></i>
                    </p>
                </div>

                <div class="bm single rd6 <?php if ($page === "intern") {
                                                echo "active";
                                            } ?>" onclick="window.location.replace('<?php echo $url->intern; ?>');">
                    <p>
                        <i class="ri-shield-user-fill std"></i>
                    </p>
                </div>

                <div class="bm single rd6" onclick="window.open('https://www.github.com/brudermusscode/thinkquotes');">
                    <p>
                        <i class="ri-github-fill std"></i>
                    </p>
                </div>



            </div>


        </div>

        <div class="rt-content">

            <div class="disfl fldirrow rt">

                <?php if (LOGGED) { ?>

                    <usermainmenu>
                        <div class="disfl fldirrow">

                            <hellofresh <?php if ($my->post_permissions == "none") { ?>disabled="true" <?php } ?> data-action="popup:quotes,add" class="hellofresh hover-shadow green rd6 icon-only mr12">
                                <div class="c-ripple js-ripple">
                                    <span class="c-ripple__circle"></span>
                                </div>
                                <p class="lt posabs alignmiddle">
                                    <i class="ri-quill-pen-fill std"></i>
                                </p>

                                <div class="cl"></div>
                            </hellofresh>

                            <div data-react="check:friends,request" class="posrel" style="z-index:2;" travelhereboy>

                                <hellofresh data-action="dropdown:open" class="<?php if ($my->check_friendrequests == "false") {
                                                                                    echo "pulse";
                                                                                } ?> hellofresh hover-shadow dark rd6 icon-only mr12">
                                    <div class="c-ripple js-ripple">
                                        <span class="c-ripple__circle"></span>
                                    </div>

                                    <p class="lt posabs alignmiddle">
                                        <i class="ri-menu-5-fill std"></i>
                                    </p>

                                    <div class="cl"></div>
                                </hellofresh>

                                <dropdown data-dropdown="header,usermenu" data-react="dropdown:open" class="mshd-2">
                                    <div class="dd-inr">
                                        <ul>

                                            <li class="has-icon trimt" onclick="window.location.replace('/u/profile/<?php echo UID; ?>');">
                                                <p>
                                                    <i class="ri-user-smile-fill small"></i>
                                                </p>
                                                <p>Profile</p>
                                            </li>

                                            <?php if ($hasFriendsRequests) { ?>
                                                <div data-react="remove:friendrequest,container">
                                                    <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

                                                    <li data-action="popup:users,friendrequests" class="friendrequest <?php if ($my->check_friendrequests === "false") echo "hasRequest"; ?> has-icon trimt">
                                                        <p class="align-mid-vert">
                                                            <span class="material-icons-round md-18">emoji_people</span>
                                                        </p>
                                                        Friendrequests
                                                    </li>

                                                    <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>
                                                </div>
                                            <?php } ?>
                                            <li class="has-icon trimt" onclick="window.location.replace('/u/favorites/<?php echo UID; ?>');">
                                                <p>
                                                    <i class="ri-heart-3-fill small"></i>
                                                </p>
                                                <p>Favorite quotes</p>
                                            </li>

                                            <li class="has-icon trimt" data-action="popup:users,settings">
                                                <p>
                                                    <i class="ri-settings-6-fill small"></i>
                                                </p>
                                                <p>Settings</p>
                                            </li>

                                            <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

                                            <li class="has-icon trimt tac" data-action='popup:signout' style="color:var(--colour-red);">
                                                <p>
                                                    <i class="ri-logout-circle-r-fill small"></i>
                                                </p>
                                                <p>Leave</p>
                                            </li>
                                        </ul>
                                    </div>
                                </dropdown>
                            </div>

                        </div>
                    </usermainmenu>

                <?php } else { ?>

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