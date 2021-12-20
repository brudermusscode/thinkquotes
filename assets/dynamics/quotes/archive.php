<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set JSON content type
header('Content-Type: application/json; charset=utf-8');

if (!empty($_POST["qid"])) {

    $qid = (int) $_POST["qid"];

    // set fckn transaction man
    // stahp forgetting
    $pdo->beginTransaction();

    // update quote
    $stmt = $pdo->prepare("UPDATE quotes SET deleted = CASE WHEN deleted = '1' THEN '0' ELSE '1' END WHERE id = ?");
    $stmt = $system->execute($stmt, [$qid], $pdo, true);

    if ($stmt->status) {

        // get current state
        $stmt = $pdo->prepare("SELECT deleted FROM quotes WHERE id = ? LIMIT 1");
        $stmt->execute([$qid]);

        // fetch
        $stmt = $stmt->fetch()->deleted;

        $return->status = true;
        $return->state = $stmt;

        // set return message for archived or unarchived
        if ($return->state) {

            $return->message = "Your quote has been archived";
        } else {

            $return->message = "Your quote has been unarchived";
        }

        $pdo = NULL;

        exit(json_encode($return));
    } else {
        exit(json_encode($return));
    }
} else {
    exit(json_encode($return));
}
