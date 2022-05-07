<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// begin mysql transaction
$pdo->beginTransaction();

if (isset($_POST["action"]) && $_POST["action"] !== "" && $logged) {

    $action = $_POST['action'];

    $validActions = [
        "check_updates",
        "check_friendrequests"
    ];

    if (in_array($action, $validActions)) {

        switch ($action) {
            case "check_updates":
                $sql = "UPDATE users_settings SET check_updates = 'true' WHERE uid = ?";
                break;
            case "check_friendrequests":
                $sql = "UPDATE users_settings SET check_friendrequests = 'true' WHERE uid = ?";
                break;
            default:
                exit("0");
        }

        $update = $pdo->prepare($sql);
        $update->execute([$my->id]);

        if ($update) {

            $pdo->commit();
            exit("1"); // success
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
