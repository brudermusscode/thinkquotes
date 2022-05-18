<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set JSON content type
header('Content-Type: application/json; charset=utf-8');

if (
    isset(
        $_REQUEST["aid"],
        $_REQUEST["quote"],
        $_REQUEST["qid"],
        $_REQUEST["source"]
    ) &&
    !empty($_REQUEST["aid"]) &&
    is_numeric($_REQUEST["aid"]) &&
    !empty($_REQUEST["quote"]) &&
    !empty($_REQUEST["qid"]) &&
    is_numeric($_REQUEST["qid"]) &&
    !empty($_REQUEST["source"]) &&
    LOGGED
) {

    // TODO: validate request values
    $aid = htmlspecialchars($_REQUEST["aid"]);
    $quote = htmlspecialchars($_REQUEST["quote"]);
    $qid = htmlspecialchars($_REQUEST["qid"]);
    $source = htmlspecialchars($_REQUEST["source"]);

    // start mysql transaction
    $pdo->beginTransaction();

    // insert the author
    $stmt = $pdo->prepare("INSERT INTO quotes_sources (uid, source_name) VALUES (?, ?)");
    $stmt = $THQ->execute($stmt, [$my->uid, $source], $pdo, false);

    if ($stmt->status) {

        // store the new id in aid variable
        $sid = $stmt->lastInsertId;

        // check for permissions of user to add new things
        // before actually committing
        if ($my->post_permissions !== "full") {

            $return->message = "Please choose from preset sources. Your permissions aren't set to add new ones";
            exit(json_encode($return));
        }
    } else {

        // switch to return error codes of thrown exception
        switch ($stmt->code) {

                // ducplicate key entry on source_name
                // keep the source name and continue the script
            case "23000":

                // select the source and get the id
                $stmt = $pdo->prepare("SELECT * FROM quotes_sources WHERE source_name = ? LIMIT 1");
                $stmt->execute([$source]);

                // check again if source exists
                if ($stmt->rowCount() < 1) {
                    exit(json_encode($return));
                }

                // fetch the select statement and store the id
                $sid = $stmt->fetch()->id;
                break;

            default:
                exit(json_encode($return));
                break;
        }
    }

    // update quote and set category
    $stmt = $pdo->prepare("UPDATE quotes SET sid = ? WHERE id = ? AND uid = ?");
    $stmt = $THQ->execute($stmt, [$sid, $qid, $my->uid], $pdo, true);

    if ($stmt->status) {

        // get the content for adding sources
        // TODO: find better method to include the file
        $content = file_get_contents($url->main . "/assets/dynamics/steps/quotes/elements/categories.php");

        // replace %% with actual strings
        // in this case the author, quote and the source
        $content = str_replace("%author%", $aid, $content);
        $content = str_replace("%quote%", $quote, $content);
        $content = str_replace("%source%", $source, $content);

        // set the status for return to true
        $return->status = true;

        // add values to return object
        $return->aid = $aid;
        $return->quote = $quote;
        $return->qid = $qid;
        $return->sid = $sid;

        // pass the content from the PHP file to the return message
        $return->message = $content;

        // return the content formatted as JSON
        exit(json_encode($return));
    } else {
        exit(json_encode($return));
    }
} else {
    exit(json_encode($return));
}
