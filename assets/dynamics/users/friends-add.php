<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$pdo->beginTransaction();

if (
    isset($_POST["uid"], $_POST["action"])
    && $_POST["uid"] !== ""
    && $_POST["action"] !== ""
    && $logged
) {

    $errorCount = 0;
    $uid = $collection->only($_POST["uid"], "num");
    $myuid = $_SESSION["id"];
    $action = $_POST["action"];

    if ($uid === $sessionid)
        exit("0");

    $validActions = [
        "addFriend",
        "cancelFriend",
        "removeFriend"
    ];

    if (in_array($action, $validActions)) {

        // check user existence...
        $getUser = $pdo->prepare("
            SELECT *, users.id AS uid, users_settings.id AS usid 
            FROM users, users_settings 
            WHERE users.id = users_settings.uid 
            AND users.id = ?
            LIMIT 1
        ");
        $getUser->execute([$uid]);
        if ($getUser->rowCount() > 0) {

            // fetch got user
            $u = $getUser->fetch();

            // switch through actions
            switch ($action) {

                    // requested add friend
                case "addFriend":

                    // check if already friends...
                    $getFriendship = $pdo->prepare("
                        SELECT uid1, uid2 
                        FROM users_friends 
                        WHERE (uid1 = ? AND uid2 = ?) 
                        OR (uid1 = ? AND uid2 = ?) 
                        LIMIT 1
                    ");
                    $getFriendship->execute([$uid, $myuid, $myuid, $uid]);

                    // ...no friends by now
                    if ($getFriendship->rowCount() < 1) {

                        $canSend = false;
                        $friends = new friends;
                        $isFriendOfFriends = $friends->getFriendsOfFriends($uid);

                        // check if user has permission to send friendrequest...
                        switch ($u->send_friendrequests) {
                            case "all":
                                $canSend = true;
                                break;
                            case "friendsoffriends":
                                if (!in_array($myuid, $isfriendoffriend)) {
                                    $canSend = false;
                                } else {
                                    $canSend = true;
                                }
                                break;
                            default:
                                $canSend = false;
                        }

                        // ...user has permissions
                        if ($canSend) {

                            // check if already sent
                            $getFriendsRequests = $pdo->prepare("
                                SELECT id, sent, got 
                                FROM users_friends_requests 
                                WHERE (sent = ? AND got = ?) 
                                OR (sent = ? AND got = ?) 
                                LIMIT 1
                            ");
                            $getFriendsRequests->execute([$uid, $myuid, $myuid, $uid]);
                            if ($getFriendsRequests->rowCount() < 1) {

                                // insert new friendsrequest
                                $insert = $pdo->prepare("INSERT INTO users_friends_requests (sent, got) VALUES (?,?)");
                                $insert->execute([$myuid, $uid]);
                                $update = $pdo->prepare("UPDATE users_settings SET check_friendrequests = 'false' WHERE uid = ?");
                                $update->execute([$uid]);

                                if (!$insert || !$update) {
                                    $errorCount++;
                                }
                            } else {
                                exit("0");
                            }
                        } else {
                            exit("2"); // no permissions to send
                        }
                    } else {
                        exit('0');
                    } // already friends

                    break;

                    // requested cancel friendrequest
                case "cancelFriend":

                    // check if already sent
                    $getFriendsRequests = $pdo->prepare("
                        SELECT id, sent, got 
                        FROM users_friends_requests 
                        WHERE (sent = ? AND got = ?) 
                        OR (sent = ? AND got = ?) 
                        LIMIT 1
                    ");
                    $getFriendsRequests->execute([$uid, $myuid, $myuid, $uid]);
                    if ($getFriendsRequests->rowCount() > 0) {

                        // get all friendsrequests of user got
                        $getFriendrequestsCount = $pdo->prepare("SELECT id FROM users_friends_requests WHERE got = ?");
                        $getFriendrequestsCount->execute([$uid]);

                        if (($getFriendrequestsCount->rowCount() - 1) === 0 && $u->check_friendrequests === "false") {
                            $update = $pdo->prepare("UPDATE users_settings SET check_friendrequests = 'true' WHERE uid = ?");
                            $update->execute([$uid]);

                            if (!$update) {
                                $errorCount++;
                            }
                        }

                        // delete friendsrequest
                        $delete = $pdo->prepare("DELETE FROM users_friends_requests WHERE (sent = ? AND got = ?) OR (sent = ? AND got = ?)");
                        $delete->execute([$uid, $myuid, $myuid, $uid]);

                        if (!$delete) {
                            $errorCount++;
                        }
                    } else {
                        exit("0");
                    }

                    break;

                    // requested delete friendship
                case "removeFriend":

                    // check if friends...
                    $getFriendship = $pdo->prepare("
                        SELECT id, uid1, uid2 
                        FROM users_friends 
                        WHERE (uid1 = ? AND uid2 = ?) 
                        OR (uid1 = ? AND uid2 = ?) 
                        LIMIT 1
                    ");
                    $getFriendship->execute([$uid, $myuid, $myuid, $uid]);

                    // ...yes, we are friends
                    if ($getFriendship->rowCount() > 0) {

                        // fetch friendship for ID
                        $fsid = $getFriendship->fetch();

                        $delete = $pdo->prepare("
                            DELETE FROM users_friends 
                            WHERE id = ?
                        ");
                        $delete->execute([$fsid->id]);

                        if (!$delete) {
                            $errorCount++;
                        }
                    } else {
                        exit("0");
                    }

                    break;

                default:
                    exit("0");
            } // switch

            if ($errorCount === 0) {

                $pdo->commit();

                if ($action === "cancelFriend") {
                    exit("3"); // canceled friendrequest
                } else if ($action === "addFriend") {
                    exit("4"); // added friendrequest
                } else {
                    exit("5"); // deleted friend
                }
            } else {

                $pdo->rollback();
                exit("0");
            }
        } else {
            exit("0");
        } // check user existence
    } else {
        exit("0");
    } // validate actions
} else {
    exit('0');
} // validate logged in
