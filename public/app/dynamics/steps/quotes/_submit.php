<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (
    isset(
        $_REQUEST["qid"]
    ) &&
    is_numeric($_REQUEST["qid"]) &&
    LOGGED
) {

    // check if the user has enough permission to post new quotes
    if ($my->post_permissions !== "none") {

        // variablize
        $qid = htmlspecialchars($_REQUEST["qid"]);

        // start transaction
        $pdo->beginTransaction();

        // insert quote
        $stmt = $pdo->prepare("UPDATE quotes SET isDraft = '0' WHERE id = ? AND uid = ?");
        $stmt = $system->execute($stmt, [$qid, UID], $pdo, true);

        // there was an error inserting
        if ($stmt->status) {

            // get quotes id
            $qid = $stmt->lastInsertId;

            $return->status = true;
            $return->message = NULL;
            exit(json_encode($return));
        }
    } else {
        $return->message = "You do not have permission to post new quotes";
        exit(json_encode($return));
    }
} else {
    exit(json_encode($return));
}
