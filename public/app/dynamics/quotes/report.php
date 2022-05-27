<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (empty($_POST["quote_id"]) || empty($_POST["report_reason"]) || empty($_POST["report_comment"]) || !LOGGED) exit(json_encode($return));

(int) $quote_id = $_POST["quote_id"];
(string) $report_reason = $_POST["report_reason"];
(string) $report_comment = $_POST["report_comment"];

# get quote by qid
$query = "SELECT COUNT(*) FROM quotes WHERE id = ?";
$get_quote = $THQ->select($pdo, $query, [$quote_id], false);

if ($get_quote->stmt->rowCount() < 1) return json_encode($return);

// * start mysql transaction
$pdo->beginTransaction();

# insert report
$q = "INSERT INTO quotes_reports (user_id, quote_id, quote_reports_category_id, comment) VALUES (?, ?, ?, ?)";
$insert_quote_report = $THQ->insert($q, [$my->uid, $quote_id, $report_reason, $report_comment], true);

# check if it was successfully
if (!$insert_quote_report->status) return json_encode($return);

$return->status = true;

# set return message for archived or unarchived
$return->message = "Thanks!";

$pdo = NULL;

exit(json_encode($return));
