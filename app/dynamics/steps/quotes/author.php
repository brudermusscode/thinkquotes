<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set JSON content type
header('Content-Type: application/json; charset=utf-8');

if (isset($_POST) && LOGGED) {
    if ($my->post_permissions !== "none") {

        // get the content for adding sources
        // TODO: find better method to include the file
        $content = file_get_contents($url->main . "/assets/dynamics/steps/quotes/elements/author.php");

        // set the status for return to true
        $return->status = true;

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
