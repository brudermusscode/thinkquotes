<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

# set the header response to format json
header(JSON_RESPONSE_FORMAT);

# start mysql transaction, all or nothing bro
$pdo->beginTransaction();

# user id & action have to be set
if (empty($_POST["uid"]) || empty($_POST["action"]) || !LOGGED) exit(null);

(int) $errorCount = 0;
(int) $uid = $collection->only($_POST["uid"], "num");
(string) $action = $_POST["action"];

# ! exit out, if current user equals requested user
if ($uid === $my->uid) exit(null);

# define valid actions
$validActions = [
    "addFriend",
    "cancelFriend",
    "removeFriend"
];

# ! exit if another action has been sent over
if (in_array($action, $validActions)) exit(null);

# check user existence
$query = "SELECT *, users.id AS uid, users_settings.id AS usid
    FROM users, users_settings
    WHERE users.id = users_settings.uid
    AND users.id = ?
    LIMIT 1";
$get_user = $system->select($pdo, $query, [$uid], false);

# ! exit if no user can be found
if ($get_user->stmt->rowCount() > 0) exit(null);

# fetch got user
$u = $get_user->fetch;

# switch through actions
switch ($action) {

    case "addFriend":

        $query = "SELECT uid1, uid2
            FROM users_friends
            WHERE (uid1 = ? AND uid2 = ?)
            OR (uid1 = ? AND uid2 = ?)
            LIMIT 1";
        $get_friendship = $system->select($pdo, $query, [$uid, $my->uid, $my->uid, $uid], false);

        # ! exit out if friends already
        if (!$get_friendship->stmt->rowCount() < 1) exit(null);

        $canSend = false;
        $friends = new friends;
        $isFriendOfFriends = $friends->getFriendsOfFriends($uid);

        # check if user has permission to send friendrequest...
        switch ($u->send_friendrequests) {
            case "all":
                $canSend = true;
                break;
            case "friendsoffriends":
                if (!in_array($my->uid, $isfriendoffriend)) {
                    $canSend = false;
                } else {
                    $canSend = true;
                }
                break;
            default:
                $canSend = false;
        }

        # ...user has permissions
        if ($canSend) {

            # check if already sent
            $getFriendsRequests = $pdo->prepare("
                                SELECT id, sent, got
                                FROM users_friends_requests
                                WHERE (sent = ? AND got = ?)
                                OR (sent = ? AND got = ?)
                                LIMIT 1
                            ");
            $getFriendsRequests->execute([$uid, $my->uid, $my->uid, $uid]);
            if ($getFriendsRequests->rowCount() < 1) {

                # insert new friendsrequest
                $insert = $pdo->prepare("INSERT INTO users_friends_requests (sent, got) VALUES (?,?)");
                $insert->execute([$my->uid, $uid]);
                $update = $pdo->prepare("UPDATE users_settings SET check_friendrequests = 'false' WHERE uid = ?");
                $update->execute([$uid]);

                if (!$insert || !$update) {
                    $errorCount++;
                }
            } else {
                exit("0");
            }
        } else {
            exit("2"); # no permissions to send
        }

        break;

        # requested cancel friendrequest
    case "cancelFriend":

        # check if already sent
        $getFriendsRequests = $pdo->prepare("
                        SELECT id, sent, got
                        FROM users_friends_requests
                        WHERE (sent = ? AND got = ?)
                        OR (sent = ? AND got = ?)
                        LIMIT 1
                    ");
        $getFriendsRequests->execute([$uid, $my->uid, $my->uid, $uid]);
        if ($getFriendsRequests->rowCount() > 0) {

            # get all friendsrequests of user got
            $getFriendrequestsCount = $pdo->prepare("SELECT id FROM users_friends_requests WHERE got = ?");
            $getFriendrequestsCount->execute([$uid]);

            if (($getFriendrequestsCount->rowCount() - 1) === 0 && $u->check_friendrequests === "false") {
                $update = $pdo->prepare("UPDATE users_settings SET check_friendrequests = 'true' WHERE uid = ?");
                $update->execute([$uid]);

                if (!$update) {
                    $errorCount++;
                }
            }

            # delete friendsrequest
            $delete = $pdo->prepare("DELETE FROM users_friends_requests WHERE (sent = ? AND got = ?) OR (sent = ? AND got = ?)");
            $delete->execute([$uid, $my->uid, $my->uid, $uid]);

            if (!$delete) {
                $errorCount++;
            }
        } else {
            exit("0");
        }

        break;

        # requested delete friendship
    case "removeFriend":

        # check if friends...
        $getFriendship = $pdo->prepare("
                        SELECT id, uid1, uid2
                        FROM users_friends
                        WHERE (uid1 = ? AND uid2 = ?)
                        OR (uid1 = ? AND uid2 = ?)
                        LIMIT 1
                    ");
        $getFriendship->execute([$uid, $my->uid, $my->uid, $uid]);

        # ...yes, we are friends
        if ($getFriendship->rowCount() > 0) {

            # fetch friendship for ID
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
} # switch

if ($errorCount === 0) {

    $pdo->commit();

    if ($action === "cancelFriend") {
        exit("3"); # canceled friendrequest
    } else if ($action === "addFriend") {
        exit("4"); # added friendrequest
    } else {
        exit("5"); # deleted friend
    }
} else {

    $pdo->rollback();
    exit("0");
}
