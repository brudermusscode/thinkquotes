<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$pdo->beginTransaction();

if (
    isset($_POST["cid"], $_POST["qid"], $_POST["comment"])
    && $isLoggedIn
) {

    if (
        $_POST["qid"] != ""
        && $_POST["cid"] != "0"
    ) {

        $r = [
            "qid" => $_POST["qid"],
            "cid" => $_POST["cid"],
            "comment" => $_POST["comment"],
            "uid" => $_SESSION['id']
        ];

        // check quote existence
        $getQuote = $pdo->prepare("
            (SELECT id FROM quotes WHERE id = ?)
            UNION ALL
            (SELECT id FROM quotes_reports_categories WHERE id = ?)
        ");
        $getQuote->execute([$r["qid"], $r["cid"]]);

        if ($getQuote->rowCount() > 1) {

            // insert report
            $insertReport = $pdo->prepare("INSERT INTO quotes_reports (uid, qid, cid, comment) VALUES (?,?,?,?)");
            $insertReport->execute([$r["uid"], $r["qid"], $r["cid"], $r["comment"]]);

            if ($insertReport) {

                $pdo->commit();
                exit('1');
            } else {

                $pdo->rollback();
                exit('0');
            }
        } else {
            exit('0');
        }
    } else {
        exit('2');
    } // reason empty
} else {
    exit('0');
} // unknown error
