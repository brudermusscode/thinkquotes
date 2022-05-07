<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST) && $isLoggedIn) {

    $pdo->beginTransaction();
    // update friendrequests settings
    $update = $pdo->prepare("UPDATE users_settings SET check_friendrequests = 'true' WHERE uid = ?");
    $update->execute([$my->id]);
    if ($update)
        $pdo->commit();

?>

    <popup-module class="login pb62">

        <label class="slideUp posrel">
            <div class="inr" style="padding:24px 42px;">
                <p class="fs24 lt ttup mr24" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                    Friendrequests
                </p>

                <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                    <p class="posabs alignmiddle"><span class="material-icons-round md-24">close</span></p>
                </div>

                <div class="cl"></div>
            </div>
        </label>

        <div class="zoom-in popup-shd rd10" style="background-color:var(--colour-dark);">

            <div class="inr small posrel" style="z-index:1;padding:18px 12px;">

                <div>
                    <div class="friendrequests-outer">

                        <?php

                        // get freindrequests
                        $getFriendsRequests = $pdo->prepare("
                            SELECT *, users_friends_requests.id AS ufrid, users.id AS uid, users_friends_requests.timestamp AS ufrts
                            FROM users_friends_requests, users, users_settings 
                            WHERE users_friends_requests.sent = users.id 
                            AND users.id = users_settings.uid 
                            AND got = ?
                            ORDER BY ufrid
                            DESC
                        ");
                        $getFriendsRequests->execute([$sessionid]);

                        if ($getFriendsRequests->rowCount() < 1) {

                            include_once $sroot . "/assets/dynamics/content/friends-requests-empty.php";
                        } else {

                            $timeAgoObject = new convertToAgo;

                            foreach ($getFriendsRequests->fetchAll() as $fr) {

                                $when = $timeAgoObject->timeago($fr->ufrts);

                        ?>


                                <div class="fr-inr" data-append="overlay">

                                    <div class="image-outer">
                                        <div class="actual">
                                            <p class="posabs alignmiddle isDark"><?php echo strtoupper(substr($fr->uname, 0, 1)); ?></p>
                                        </div>
                                    </div>

                                    <div class="text-outer">

                                        <div class="username">
                                            <p class="fw7 trimt"><?php echo $fr->uname; ?></p>
                                        </div>

                                        <div class="timestamp" style="font-style:italic;opacity:.6;font-size:.8em;">
                                            <p><?php echo $when; ?></p>
                                        </div>

                                    </div>

                                    <div class="cl"></div>

                                    <div class="options">
                                        <div class="disfl fldirrow">

                                            <hellofresh data-action='function:friends,request,accept/decline' data-json='[{"frid":"<?php echo $fr->ufrid; ?>","usid":"<?php echo $fr->sent; ?>","action":"acceptRequest"}]' class="hellofresh green rd6 icon-only mr12 circled small">
                                                <div class="c-ripple js-ripple">
                                                    <span class="c-ripple__circle"></span>
                                                </div>
                                                <p class="lt posabs alignmiddle">
                                                    <span class="material-icons-round md-24">done</span>
                                                </p>
                                                <div class="cl"></div>
                                            </hellofresh>

                                            <hellofresh data-action='function:friends,request,accept/decline' data-json='[{"frid":"<?php echo $fr->ufrid; ?>","usid":"<?php echo $fr->sent; ?>","action":"declineRequest"}]' class="hellofresh darkred dark rd6 icon-only circled small">
                                                <div class="c-ripple js-ripple">
                                                    <span class="c-ripple__circle"></span>
                                                </div>
                                                <p class="lt posabs alignmiddle">
                                                    <span class="material-icons-round md-24">close</span>
                                                </p>
                                                <div class="cl"></div>
                                            </hellofresh>

                                            <div class="cl"></div>
                                        </div>
                                    </div>

                                </div>

                        <?php

                            }
                        }

                        ?>

                    </div>
                </div>

            </div>

        </div>

    </popup-module>


<?php

} else {
    exit("0");
}

?>