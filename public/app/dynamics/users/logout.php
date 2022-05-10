<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

// you always forget to set transactions.
// So pls don't start forgetting setting up json header output man
header('Content-Type: application/json; charset=utf-8');

// check if session is actually active
if (!session_status() === PHP_SESSION_ACTIVE) exit(json_encode($return));

// call logout function to remove cookies
$sign->logout();

// reassign return object
$return->status = true;
$return->message = "You have been logged out, see you again, my friend";

// exit script
exit(json_encode($return));
