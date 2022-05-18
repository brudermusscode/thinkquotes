<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set JSON content type
header('Content-Type: application/json; charset=utf-8');

if (
    isset(

        $_REQUEST["aid"],
        $_REQUEST["quote"]
    ) &&
    !empty($_REQUEST["aid"]) &&
    is_numeric($_REQUEST["aid"]) &&
    !empty($_REQUEST["quote"]) &&
    LOGGED
) {

    // TODO: validate request values
    $aid = htmlspecialchars($_REQUEST["aid"]);
    $quote = htmlspecialchars($_REQUEST["quote"]);

    // check if the user has permissions to add new quotes
    if ($my->post_permissions !== "none") {

        // start mysql transaction
        $pdo->beginTransaction();

        // insert the quote as a draft at first
        $stmt = $pdo->prepare("INSERT INTO quotes (uid, aid, quote_text) VALUES (?, ?, ?)");
        $stmt = $THQ->execute($stmt, [$my->uid, $aid, $quote], $pdo, true);

        if ($stmt->status) {

            // get quote's insert id
            $qid = $stmt->lastInsertId;

            // get the content for adding sources
            // TODO: find better method to include the file
            $content = file_get_contents($url->main . "/assets/dynamics/steps/quotes/elements/source.php");

            // replace %% with actual strings
            // in this case the author and the quote
            $content = str_replace("%author%", $aid, $content);
            $content = str_replace("%quote%", $quote, $content);

            // set the status for return to true
            $return->status = true;

            // save values from REQUEST variables into return object
            $return->aid = $aid;
            $return->quote = $quote;
            $return->qid = $qid;

            // pass the content from the PHP file to the return message
            $return->message = $content;

            // exit the script with encoding the return array to JSON
            exit(json_encode($return));
        } else {
            $return->message = "Couldn't save your quote as a draft, something went wrong. Please close the overlay and try again";
            exit(json_encode($return));
        }
    } else {
        exit(json_encode($return));
    }
} else {
    exit(json_encode($return));
}
