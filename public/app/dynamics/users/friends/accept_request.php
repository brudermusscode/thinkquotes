<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

# set the header response to format json
header(JSON_RESPONSE_FORMAT);

# user id & action have to be set
if (empty($_POST["id"]) || empty($_POST["uid"]) || !LOGGED) exit(null);

$return->log = (object) [];

(int) $id = $_POST["id"];
(int) $user_id = $_POST["uid"];

# TODO: #27 STAHP FORGETTING TO START TRANSACTIOPN OMFG
$pdo->beginTransaction();

# ----------------------------------------------------------------
# check if request exists
$q =
  "SELECT *
  FROM users_friends_requests
  WHERE ((sent = ? AND got = ?)
  OR (sent = ? AND got = ?))
  AND id = ?
  LIMIT 1";
$get_friend_request = $THQ->select($pdo, $q, [$my->uid, $user_id, $user_id, $my->uid, $id], false);

if (!$get_friend_request->status || !$get_friend_request->stmt->rowCount() > 0) {
  $return->message = get_return_message_with(1);
  exit(json_encode($return));
}

# add new friendship
$q = "INSERT INTO users_friends (user_1_id, user_2_id) VALUES (?, ?)";
$insert_friend_request = $THQ->insert($q, [$my->uid, $user_id], false);

if (!$insert_friend_request->status) {
  $return->message = get_return_message_with(2);
  exit(json_encode($return));
}

# delete left over friend request
$q = "DELETE FROM users_friends_requests WHERE (sent = ? AND got = ?) OR (sent = ? AND got = ?)";
$delete_friend_request = $THQ->insert($q, [$my->uid, $user_id, $user_id, $my->uid], true);

if (!$delete_friend_request->status) {
  $return->message = get_return_message_with(3);
  exit(json_encode($return));
}

# prepare return object
$return->status = true;
$return->action = 'accept_request';
$return->message = get_return_message_with(4);

# close pdo connection
$pdo = NULL;

exit(json_encode($return));


function get_return_message_with(int $code)
{
  if ($code == 1) return 'Something is wrong with this friendrequest!';
  if ($code == 2) return 'We could not create a new friendship! Try again';
  if ($code == 3) return 'Something is wrong here. You might want to try again';
  if ($code == 4) return 'You are now friends with this user!';
}
