<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

# set header response to json
header(JSON_RESPONSE_FORMAT);

if (empty($_POST['author']) || !LOGGED) exit(json_encode($return));

(string) $author = $_POST['author'];
(int) $author_id = 0;

# ! start mysql transaction #ALLORNOTHING
$pdo->beginTransaction();

# search for author already existing
$q = "SELECT * FROM quotes_authors WHERE author_name = ? LIMIT 1";
$get_author = $THQ->select($pdo, $q, [$author], false);

if ($get_author->stmt->rowCount() > 0) {

  $author_id = $get_author->fetch->id;
} else {

  # check for permissions to add new authors
  if ($my->post_permissions != 'full') {
    $return->message = get_return_message_with(1);
    exit(json_encode($return));
  }

  # try inserting new author
  $q = "INSERT INTO quotes_authors (uid, author_name) VALUES (?, ?)";
  $insert_author = $THQ->insert($q, [$my->uid, $author], false);

  # check if it was successfully
  if (!$insert_author->status) {
    $return->message = get_return_message_with(2);
    exit(json_encode($return));
  }

  # get last insert id for author (aid)
  $author_id = $insert_author->connection->lastInsertId();
}

# create quote draft (is_draft = 1 automatically)
$q = "INSERT INTO quotes (uid, aid) VALUES (?, ?)";
$insert_quote = $THQ->insert($q, [$my->uid, $author_id], false);

# check if it was successfully
if (!$insert_quote->status) {
  $return->message = get_return_message_with(3);
  exit(json_encode($return));
}

# get last insert id for author (aid)
$quote_id = $insert_quote->connection->lastInsertId();

# set return status to true/1 for javascript
$return->status = true;
$return->quote_id = (int) $quote_id;

# commit all changes
$insert_quote->connection->commit();

# exit out with return json encoded $return object
exit(json_encode($return));

function get_return_message_with(int $code)
{
  if ($code == 1) return (string) "You cannot add authors yet.";
  if ($code == 2) return (string) "The author couldn't be added, you might want to try again!";
  if ($code == 3) return (string) "We couldn't create a draft for your quote, you might want to try again!";
}
