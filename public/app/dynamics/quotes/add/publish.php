<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set header response to json
header(JSON_RESPONSE_FORMAT);

if (empty($_POST['quote_id']) || !LOGGED) exit(json_encode($return));

(int) $quote_id = $_POST['quote_id'];

# get quote
$q =
  "SELECT q.*
    FROM quotes q
    WHERE q.id = ? AND q.uid = ? AND q.is_draft = true
    LIMIT 1";
$get_quote = $THQ->select($pdo, $q, [$quote_id, $my->uid], false);

if (!$get_quote->status) {
  $return->message = get_return_message_with(1);
  exit(json_encode($return));
}

if (!$get_quote->stmt->rowCount() > 0) {
  $return->message = get_return_message_with(2);
  exit(json_encode($return));
}

# ! start mysql transaction #ALLORNOTHING
$pdo->beginTransaction();

# update quote
$q = "UPDATE quotes SET is_draft = false WHERE id = ? AND uid = ?";
$update_quote = $THQ->update($pdo, $q, [$quote_id, $my->uid], true);

# check if it was successfullyy
if (!$update_quote->status) {
  $return->message = get_return_message_with(2);
  exit(json_encode($return));
}

$return->status = true;
$return->message = '';

exit(json_encode($return));

function get_return_message_with(int $code)
{
  if ($code == 1) return (string) "Something went wrong, try again!";
  if ($code == 2) return (string) "Something is wrong with your draft!";
  if ($code == 3) return (string) "We couldn't publish your quote, you might want to try again!";
}
