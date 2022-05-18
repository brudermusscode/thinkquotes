<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

// set JSON content type
header(JSON_RESPONSE_FORMAT);


if (empty($_POST["qid"])) exit(json_encode($return));

(int) $qid = $_POST["qid"];

// set fckn transaction man
// stahp forgetting
$pdo->beginTransaction();

// update quote
$query = "UPDATE quotes SET deleted = CASE WHEN deleted = '1' THEN '0' ELSE '1' END WHERE id = ?";
$archive_quote = $THQ->update($pdo, $query, [$qid], true);

if (!$archive_quote->status) exit(json_encode($return));

// get current state
$stmt = $pdo->prepare("SELECT deleted FROM quotes WHERE id = ? LIMIT 1");
$stmt->execute([$qid]);

// fetch
$stmt = $stmt->fetch()->deleted;

$return->status = true;
$return->state = $stmt;

// set return message for archived or unarchived
$return->message = "Your quote has been archived";
if (!$return->state) $return->message = "Your quote has been unarchived";

# this should be done in everry script actually. May train on to add it
$pdo = NULL;

exit(json_encode($return));
