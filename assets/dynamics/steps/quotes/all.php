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
        $_REQUEST["sid"],
        $_REQUEST["category"]
    ) &&
    !empty($_REQUEST["aid"]) &&
    !empty($_REQUEST["quote"]) &&
    !empty($_REQUEST["qid"]) &&
    !empty($_REQUEST["sid"]) &&
    !empty($_REQUEST["category"]) &&
    is_numeric($_REQUEST["aid"]) &&
    is_numeric($_REQUEST["qid"]) &&
    is_numeric($_REQUEST["sid"]) &&
    LOGGED
) {

    // TODO: validate request values
    $aid = htmlspecialchars($_REQUEST["aid"]);
    $quote = htmlspecialchars($_REQUEST["quote"]);
    $qid = htmlspecialchars($_REQUEST["qid"]);
    $sid = htmlspecialchars($_REQUEST["sid"]);
    $category = htmlspecialchars($_REQUEST["category"]);

    // start mysql transaction
    $pdo->beginTransaction();

    // insert the author
    // TODO: make multiple categories adding possible
    $stmt = $pdo->prepare("INSERT INTO quotes_categories (uid, category_name) VALUES (?, ?)");
    $stmt = $system->execute($stmt, [UID, $category], $pdo, false);

    if ($stmt->status) {

        // store the new id in aid variable
        $cid = $stmt->lastInsertId;

        // check for permissions of user to add new things
        // before actually committing
        if ($my->post_permissions !== "full") {

            $return->message = "Please choose from preset categories. Your permissions aren't set to add new ones";
            exit(json_encode($return));
        }
    } else {

        // switch to return error codes of thrown exception
        switch ($stmt->code) {

                // ducplicate key entry on source_name
                // keep the source name and continue the script
            case "23000":

                // select the source and get the id
                $stmt = $pdo->prepare("SELECT * FROM quotes_categories WHERE category_name = ? LIMIT 1");
                $stmt->execute([$category]);

                // check again if source exists
                if ($stmt->rowCount() < 1) {
                    exit(json_encode($return));
                }

                // fetch the select statement and store the id
                $cid = $stmt->fetch()->id;
                break;

            default:
                exit(json_encode($return));
        }
    }

    // insert into categories used for relation between quote and category
    $stmt = $pdo->prepare("INSERT INTO quotes_categories_used (qid, cid) VALUES (?, ?)");
    $stmt = $system->execute($stmt, [$qid, $cid], $pdo, true);

    if ($stmt->status) {

        // get the content for adding sources
        // TODO: find better method to include the file
        $content = file_get_contents($url->main . "/assets/dynamics/steps/quotes/elements/all.php");

        // replace %% with actual strings
        // in this case the author and the quote
        $content = str_replace("%author%", $aid, $content);
        $content = str_replace("%quote%", $quote, $content);
        $content = str_replace("%source%", $sid, $content);
        $content = str_replace("%category%", $category, $content);

        // set the status for return to true
        $return->status = true;

        // add values to return object
        $return->aid = $aid;
        $return->quote = $quote;
        $return->qid = $qid;
        $return->sid = $sid;
        $return->cid = $cid;

        // pass the content from the PHP file to the return message
        $return->message = $content;

        // exit the script with encoding the return array to JSON
        exit(json_encode($return));
    } else {
        exit(json_encode($return));
    }
} else {
    exit(json_encode($return));
}
