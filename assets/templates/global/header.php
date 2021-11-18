<?php

if (!$is_page) {
    header("location: /");
}

if ($isLoggedIn) {

    // check for friendrequests
    $friends = new friends;
    $hasFriendsRequests = $friends->getFriendrequests($sessionid);

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

        <div class="middle-logo--outer posabs alignmiddle">
            <div class="lo-sizing">
                <div class="logo mshd-1">
                    <img src="https://images.thinkquotes.de/global/new.logo.thq.png" style="visibility:hidden;opacity:0;">
                </div>
            </div>
        </div>

        <div class="lt-content">
            <div data-structure="header:base-menu" class="base-menu disfl fldirrow">
                <div class="bm single rd6 <?php if ($page === "index") {
                                                echo "active";
                                            } ?>" onclick="window.location.replace('<?php echo $main['url']; ?>');">
                    <p class="alignmiddle posabs">
                        <span class="material-icons-round md-24">space_dashboard</span>
                    </p>
                </div>

                <div class="bm single rd6 <?php if ($page === "intern") {
                                                echo "active";
                                            } ?>" onclick="window.location.replace('<?php echo $main['internurl']; ?>');">
                    <p class="alignmiddle posabs">
                        <span class="material-icons-round md-24">policy</span>
                    </p>
                </div>



            </div>


        </div>

        <div class="rt-content">

            <div class="disfl fldirrow rt">

                <?php if ($isLoggedIn) { ?>

                    <usermainmenu>

                        <div class="disfl fldirrow">
                            <hellofresh <?php if ($my["permissions"] === "none") { ?>disabled="true" <?php } ?> data-action="popup:quotes,add" class="hellofresh green rd6 icon-only shadowed mr12">
                                <div class="c-ripple js-ripple">
                                    <span class="c-ripple__circle"></span>
                                </div>
                                <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">add</span></p>

                                <div class="cl"></div>
                            </hellofresh>

                            <!--<div class="kek icon mr12">
                                <div class="kek-inr">
                                    <p><span class="material-icons-round md-24">settings</span></p>
                                </div>
                            </div>-->

                            <div class="posrel mr12">
                                <hellofresh data-action="get:content,notifications" class="hellofresh dark clean rd6 big text-shadowed icon-only">
                                    <div class="c-ripple js-ripple posrel" style="z-index:1;">
                                        <span class="c-ripple__circle"></span>
                                    </div>
                                    <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">notifications</span></p>

                                    <div class="cl"></div>
                                </hellofresh>
                            </div>

                            <div data-react="check:friends,request" class="posrel" style="z-index:2;" travelhereboy>

                                <hellofresh data-action="dropdown:open" class="<?php if ($my["check_friendrequests"] === "false") {
                                                                                    echo "pulse";
                                                                                } ?> hellofresh red dark clean rd6 big circled text-shadowed icon-only">
                                    <div class="c-ripple js-ripple">
                                        <span class="c-ripple__circle"></span>
                                    </div>
                                    <p class="lt posabs alignmiddle"><?php echo substr($my["username"], 0, 1) ?></p>

                                    <div class="cl"></div>
                                </hellofresh>

                                <dropdown data-dropdown="header,usermenu" data-react="dropdown:open" class="mshd-2">
                                    <div class="dd-inr">
                                        <ul>

                                            <li class="has-icon trimt" onclick="window.location.replace('/u/profile/<?php echo $_SESSION['id']; ?>');">
                                                <p class="align-mid-vert">
                                                    <span class="material-icons-round md-18">insert_emoticon</span>
                                                </p>
                                                Profile
                                            </li>

                                            <?php if ($hasFriendsRequests) { ?>
                                                <div data-react="remove:friendrequest,container">
                                                    <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

                                                    <li data-action="popup:users,friendrequests" class="friendrequest <?php if ($my["check_friendrequests"] === "false") echo "hasRequest"; ?> has-icon trimt">
                                                        <p class="align-mid-vert">
                                                            <span class="material-icons-round md-18">emoji_people</span>
                                                        </p>
                                                        Friendrequests
                                                    </li>

                                                    <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>
                                                </div>
                                            <?php } ?>

                                            <li class="has-icon trimt" onclick="window.location.replace('/u/favorites/<?php echo $_SESSION['id']; ?>');">
                                                <p class="align-mid-vert">
                                                    <span class="material-icons-round md-18">favorite</span>
                                                </p>
                                                Favorite quotes
                                            </li>
                                            <li class="has-icon trimt" data-action="popup:users,settings">
                                                <p class="align-mid-vert">
                                                    <span class="material-icons-round md-18">settings</span>
                                                </p>
                                                Settings
                                            </li>

                                            <div style="border-bottom:1px solid rgba(0,0,0,.06);margin:4px 12px;height:1px;"></div>

                                            <li class="has-icon trimt" data-action='popup:signout' style="color:var(--colour-red);">
                                                <p class="align-mid-vert">
                                                    <span class="material-icons-round md-18">logout</span>
                                                </p>
                                                Logout
                                            </li>
                                        </ul>
                                    </div>
                                </dropdown>
                            </div>

                        </div>

                    </usermainmenu>

                <?php } else { ?>

                    <hellofresh data-action="popup:login" class="hellofresh fw7 rd6 big mr12 clean text-shadowed" style="color:var(--colour-light);">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        Log in
                    </hellofresh>

                    <hellofresh data-action="popup:signup" class="rd6 big shadowed orange">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        Sign up
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
    <header id="intern-hdr" class="mshd-1"></header>
<?php } ?>