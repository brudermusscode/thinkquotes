<?php

$is_page = true;
$page = "profiles";

// mysql database
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// logic
include_once "logic.php";

// friends
$fr = $friends->getFriends($user->uid);
$frofr = $friends->getFriendsOfFriends($user->uid);

// Head section
include_once "../assets/templates/global/head.php";
include_once "../assets/templates/global/header.php";

?>

<div class="u-hdr mshd-1 mb32">
    <div class="u-hdr-inr posrel">

        <div class="disfl fldirrow lt">

            <!-- vielleicht lieblingszitat? -->
            <div class="posrel dno" style="border-radius:50%;height:92px;width:92px;overflow:hidden;background:var(--colour-red);">
                <div class="alignmiddle posabs">
                    <p style="color:white;font-weight:700;font-size:2em;"><?php echo substr($user->uname, 0, 1) ?></p>
                </div>
            </div>

            <div style="line-height:1;">
                <p class="trimt" style="font-family: 'Indie Flower', cursive;text-shadow:0 1px 1px rgba(0,0,0,.38);font-size:3em;font-weight:300;color:var(--colour-light);">
                    <?php echo $user->uname ?>
                </p>
            </div>

        </div>


        <?php if ($isLoggedIn) { ?>
            <div class="posabs" style="right:32px;">

                <?php

                if (!($user->uid === $sessionid)) {

                    // check if friendrequest exists
                    $getFriendRequest = $pdo->prepare("SELECT * FROM users_friends_requests WHERE (sent = ? AND got = ?) OR (sent = ? AND got = ?)");
                    $getFriendRequest->execute([$sessionid, $user->uid, $user->uid, $sessionid]);

                    // show remove friend button
                    if (in_array($sessionid, $fr)) {

                ?>

                        <hellofresh data-action='function:friends,request,send/cancel/remove' data-json='[{"uid":"<?php echo $user->uid; ?>", "action":"removeFriendRequest"}]' class="rd6 big shadowed fw7 light">
                            <div class="c-ripple js-ripple">
                                <span class="c-ripple__circle"></span>
                            </div>
                            <div class="disfl fldirrow">
                                <div class="mr12">
                                    <span class="align-mid-vert material-icons-round md-24">remove</span>
                                </div>
                                <p class="text">Remove friend</p>
                            </div>
                        </hellofresh>

                    <?php

                        // show cancel friendrequest button
                    } else if ($getFriendRequest->rowCount() > 0) {

                    ?>

                        <hellofresh data-action='function:friends,request,send/cancel/remove' data-json='[{"uid":"<?php echo $user->uid; ?>", "action":"cancelFriend"}]' class="rd6 big shadowed fw7 light">
                            <div class="c-ripple js-ripple">
                                <span class="c-ripple__circle"></span>
                            </div>
                            <div class="disfl fldirrow">
                                <div class="mr12">
                                    <span class="align-mid-vert material-icons-round md-24">not_interested</span>
                                </div>
                                <p class="text">Cancel friendrequest</p>
                            </div>
                        </hellofresh>

                        <?php

                    } else {

                        // check permissions
                        switch ($user->send_friendrequests) {
                            case "all":
                                $canSend = true;
                                break;
                            case "friendsoffriends":
                                if (!in_array($sessionid, $frofr)) {
                                    $canSend = false;
                                } else {
                                    $canSend = true;
                                }
                                break;
                            default:
                                $canSend = false;
                        }

                        if ($canSend) {

                        ?>

                            <hellofresh data-action='function:friends,request,send/cancel/remove' data-json='[{"uid":"<?php echo $user->uid; ?>", "action":"addFriend"}]' class="rd6 big shadowed fw7 light">
                                <div class="c-ripple js-ripple">
                                    <span class="c-ripple__circle"></span>
                                </div>
                                <div class="disfl fldirrow">
                                    <div class="mr12">
                                        <span class="align-mid-vert material-icons-round md-24">add_reaction</span>
                                    </div>
                                    <p class="text">Add friend</p>
                                </div>
                            </hellofresh>

                    <?php

                        }
                    }
                } else {

                    ?>

                    <hellofresh data-action="popup:profile,edit" class="rd6 big shadowed fw7 blue">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        <div class="disfl fldirrow">
                            <div class="mr12">
                                <span class="align-mid-vert material-icons-round md-24">auto_fix_normal</span>
                            </div>
                            <p>Profile editor</p>
                        </div>
                    </hellofresh>

                <?php

                }

                ?>

            </div>
        <?php } ?>

        <div class="cl"></div>
    </div>
</div>

<div id="main" class="wpx--main">

    <?php

    if (isset($subpage)) {

        switch ($subpage) {
            case "profile":
                include_once "pages/profiles.php";
                break;
            case "favorites":
                include_once "pages/favorites.php";
                break;
            default:
                header("location: ./404");
        }
    } else {
        header("location: ./404");
    }

    ?>

</div>

<?php

// foot section
include_once "../assets/templates/global/footer.php";

?>