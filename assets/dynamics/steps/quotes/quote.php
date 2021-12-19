<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set JSON content type
header('Content-Type: application/json; charset=utf-8');

if (
    isset($_REQUEST["author"]) &&
    !empty($_REQUEST["author"]) &&
    LOGGED
) {

    // variablize
    $author = htmlspecialchars($_REQUEST["author"]);

    // start mysql transaction
    $pdo->beginTransaction();

    // insert the author
    $stmt = $pdo->prepare("INSERT INTO quotes_authors (uid, author_name) VALUES (?, ?)");
    $stmt = $system->execute($stmt, [UID, $author], $pdo, false);

    if ($stmt->status) {

        // store the new id in aid variable
        $aid = $stmt->lastInsertId;

        // check for permissions of user to add new things
        // before actually committing
        if ($my->post_permissions !== "full") {

            $return->message = "Please choose from preset authors. Your permissions aren't set to add new ones";
            exit(json_encode($return));
        }

        // commit mysql transaction
        $pdo->commit();
    } else {

        // switch to return error codes of thrown exception
        switch ($stmt->code) {

                // ducplicate key entry on author_name
                // keep the author name and continue the script
            case "23000":

                // select the author and get the id
                $stmt = $pdo->prepare("SELECT * FROM quotes_authors WHERE author_name = ? LIMIT 1");
                $stmt->execute([$author]);

                // check again if author exists
                if ($stmt->rowCount() < 1) {
                    exit(json_encode($return));
                }

                // fetch the select statement and store the id
                $aid = $stmt->fetch()->id;
                break;

            default:
                exit(json_encode($return));
        }
    }

    // get the content for adding quotes
    // TODO: find better method to include the file
    $content = file_get_contents($url->main . "/assets/dynamics/steps/quotes/elements/quote.php");

    // replace %% with actual strings
    // in this case just the author
    $content = str_replace("%author%", $author, $content);

    // set the status for return to true
    $return->status = true;

    // store the author id in the return object
    $return->aid = $aid;

    // pass the content from the PHP file to the return message
    $return->message = $content;

    // exit the script with encoding the return array to JSON
    exit(json_encode($return));
} else {
    exit(json_encode($return));
}
