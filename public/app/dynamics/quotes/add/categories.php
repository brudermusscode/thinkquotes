<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

# set header response to json
header(JSON_RESPONSE_FORMAT);

if (empty($_POST['category_name']) || empty($_POST['quote_id']) || !LOGGED) exit(json_encode($return));

(string) $category_name = $_POST['category_name'];
(int) $quote_id = $_POST['quote_id'];

# ------------------------------------------------------------------
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

# ------------------------------------------------------------------
# ! start mysql transaction #ALLORNOTHING
$pdo->beginTransaction();

$q = "SELECT * FROM quotes_categories WHERE category_name = ? LIMIT 1";
$get_category = $THQ->select($pdo, $q, [$category_name], false);

if ($get_category->stmt->rowCount() > 0) {

  $category_id = $get_category->fetch->id;
} else {

  # check for permissions to add new source
  if ($my->post_permissions != 'full') {
    $return->message = get_return_message_with(1);
    exit(json_encode($return));
  }

  # try inserting new source
  $q = "INSERT INTO quotes_categories (uid, category_name) VALUES (?, ?)";
  $insert_category = $THQ->insert($q, [$my->uid, $category_name], false);

  # check if it was successfully
  if (!$insert_category->status) {
    $return->message = get_return_message_with(2);
    exit(json_encode($return));
  }

  # get last insert id for source (sid)
  $category_id = $insert_category->connection->lastInsertId();
}

# ------------------------------------------------------------------
# insert used categories for this quote
$q = "INSERT INTO quotes_categories_used (qid, cid) VALUES (?, ?)";
$insert_categories_used = $THQ->insert($q, [$quote_id, $category_id], false);

if (!$insert_categories_used->status) {
  $return->message = get_return_message_with(3);
  exit(json_encode($return));
}

# ------------------------------------------------------------------
# set return status to true/1 for javascript
$return->status = true;
$return->quote_id = (int) $quote_id;

# commit all changes
$insert_categories_used->connection->commit();

# exit out with return json encoded $return object
exit(json_encode($return));

# ------------------------------------------------------------------
function get_return_message_with(int $code)
{
  if ($code == 1) return (string) "Something went wrong, try again!";
  if ($code == 2) return (string) "Something is wrong with your draft!";
  if ($code == 3) return (string) "We couldn't update your draft for your quote, you might want to try again!";
}
