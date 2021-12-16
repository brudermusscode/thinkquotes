<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST["qid"]) && $_POST["qid"] !== "" && $logged) {

    $qid = $_POST["qid"];
    $uid = $my->id;

    // check quote existence and owner
    $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ? and uid = ?");
    $getQuote->execute([$qid, $uid]);

    if ($getQuote->rowCount() > 0) {

        // confirmed
        exit("1");
    } else {
        exit("0"); // unknown error
    }
} else {
    exit("0"); // unknown error
}
