<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$pdo->beginTransaction();

if (
    isset($_POST["frid"], $_POST["usid"], $_POST["action"])
    && $_POST["frid"] !== ""
    && $_POST["action"] !== ""
    && $logged
) {

    $frid = $collection->only($_POST["frid"], "num");
    $usid = $collection->only($_POST["usid"], "num");
    $action = $_POST["action"];
    $errorCount = 0;

    // valid actions in an array
    $validActions = [
        "acceptRequest",
        "declineRequest",
        "ignoreRequest"
    ];

    // check if valid action
    if (in_array($action, $validActions)) {

        // check if request exists
        $getRequest = $pdo->prepare("SELECT * FROM users_friends_requests WHERE id = ? AND got = ? AND sent = ?");
        $getRequest->execute([$frid, $sessionid, $usid]);

        if ($getRequest->rowCount() > 0) {

            // switch through actions
            switch ($action) {

                    // accept friendrequest
                case "acceptRequest":
                    $insert = $pdo->prepare("INSERT INTO users_friends (uid1, uid2) VALUE (?,?)");
                    $insert->execute([$sessionid, $usid]);

                    if (!$insert) {
                        $errorCount++;
                    }
                    break;

                    // decline friendrequest
                case "declineRequest":
                    break;

                    // ignore users requests
                case "ignoreRequest":

                    break;

                default:
                    exit("0");
            }

            if ($errorCount === 0) {

                // delete request
                $delete = $pdo->prepare("DELETE FROM users_friends_requests WHERE id = ? AND got = ? AND sent = ?");
                $delete->execute([$frid, $sessionid, $usid]);

                if ($delete) {

                    $pdo->commit();

                    if ($action === "acceptRequest")
                        exit("1"); // accepted
                    else if ($action === "declineRequest")
                        exit("2"); // declined
                    else
                        exit("3"); // ignored -> do something

                } else {
                    $pdo->rollback();
                    exit("0");
                }
            } else {
                exit("0");
            }
        } else {
            exit("0");
        }
    } else {
        exit("0");
    }
} else {
    exit("0");
}
