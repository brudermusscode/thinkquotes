<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set header response to json
header(JSON_RESPONSE_FORMAT);

if (empty($_POST['quote_id']) || empty($_POST['source_name']) || !LOGGED) exit(json_encode($return));

(string) $source_name = $_POST['source_name'];
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

$q = "SELECT * FROM quotes_sources WHERE source_name = ? LIMIT 1";
$get_source = $THQ->select($pdo, $q, [$source_name], false);

if ($get_source->stmt->rowCount() > 0) {

  $source_id = $get_source->fetch->id;
} else {

  # check for permissions to add new source
  if ($my->post_permissions != 'full') {
    $return->message = get_return_message_with(1);
    exit(json_encode($return));
  }

  # try inserting new source
  $q = "INSERT INTO quotes_sources (uid, source_name) VALUES (?, ?)";
  $insert_source = $THQ->insert($q, [$my->uid, $source_name], false);

  # check if it was successfully
  if (!$insert_source->status) {
    $return->message = get_return_message_with(2);
    exit(json_encode($return));
  }

  # get last insert id for source (sid)
  $source_id = $insert_source->connection->lastInsertId();
}

# try updating quote
$q = "UPDATE quotes SET sid = ? WHERE id = ?";
$update_quote = $THQ->update($pdo, $q, [$source_id, $quote_id], false);

if (!$update_quote->status) {
  $return->message = get_return_message_with(3);
  exit(json_encode($return));
}

# set return status to true/1 for javascript
$return->status = true;
$return->quote_id = (int) $quote_id;

# commit all changes
$update_quote->connection->commit();

# exit out with return json encoded $return object
exit(json_encode($return));

function get_return_message_with(int $code)
{
  if ($code == 1) return (string) "Something went wrong, try again!";
  if ($code == 2) return (string) "Something is wrong with your draft!";
  if ($code == 3) return (string) "We couldn't update your draft for your quote, you might want to try again!";
}
