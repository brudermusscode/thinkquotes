<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// you always forget to set transactions.
// So pls don't start forgetting setting up json header output man
header('Content-Type: application/json; charset=utf-8');

// check if session is actually active
if (session_status() === PHP_SESSION_ACTIVE) {

    // call logout function to remove cookies
    $sign->logout();

    // reassign return object
    $return->status = true;
    $return->message = "You have been logged out, see you again, my friend";

    // exit script
    exit(json_encode($return));
} else {
    exit(json_encode($return));
}
