<?php

require_once "./../../../session/session.inc.php";

$pdo->beginTransaction();

if (isset($_POST["qid"]) && $_POST["qid"] !== "" && $isLoggedIn) {

    $qid = $_POST["qid"];
    $uid = $_SESSION["id"];

    // check quote existence and owner
    $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ? and uid = ?");
    $getQuote->execute([$qid, $uid]);

    if ($getQuote->rowCount() > 0) {

        // it exists, set to deleted
        $deleteQuote = $pdo->prepare("UPDATE quotes SET deleted = '1' WHERE id = ? AND uid = ?");
        $deleteQuote->execute([$qid, $uid]);

        if ($deleteQuote) {

            $pdo->commit();
            exit("1"); // success

        } else {

            $pdo->rollback();
            exit("0"); // unknown error

        }
    } else {
        exit("0"); // unknown error
    }
} else {
    exit("0"); // unknown error
}
