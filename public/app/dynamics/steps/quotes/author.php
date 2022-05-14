<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

// set JSON content type
header(JSON_RESPONSE_FORMAT);

if (!isset($_POST) && !LOGGED) exit(json_encode($return));

if ($my->post_permissions == "none") exit(json_encode($return));

// get the content for adding sources
$content = file_get_contents(DYNAMICS . "/steps/quotes/elements/author.php");

// set the status for return to true
$return->status = true;

// pass the content from the PHP file to the return message
$return->message = $content;

// exit the script with encoding the return array to JSON
exit(json_encode($return));
