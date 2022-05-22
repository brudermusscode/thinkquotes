<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

# set the header response to format json
header(JSON_RESPONSE_FORMAT);

# user id & action have to be set
if (empty($_POST["uid"]) || !LOGGED) exit(null);

$return->log = (object) [];

(int) $user_id = $_POST["uid"];

# ----------------------------------------------------------------
# check if request exists
$q =
  "SELECT *
  FROM users_friends_requests
  WHERE (sent = ? AND got = ?)
  OR (sent = ? AND got = ?)
  LIMIT 1";
$get_friend_request = $THQ->select($pdo, $q, [$my->uid, $user_id, $user_id, $my->uid], false);

if (!$get_friend_request->status || !$get_friend_request->stmt->rowCount() > 0) {
  $return->message = get_return_message_with(1);
  exit(json_encode($return));
}

# get users being requested information
$q =
  "SELECT *
  FROM users u
  JOIN users_settings us ON us.uid = u.id
  WHERE u.id = ?
  LIMIT 1";
$get_user = $THQ->select($pdo, $q, [$user_id], false);

if (!$get_user->status || !$get_user->stmt->rowCount() > 0) {
  $return->message = get_return_message_with(3);
  exit(json_encode($return));
}

# ----------------------------------------------------------------
# start mysql transaction, all or nothing bro
$pdo->beginTransaction();

# ----------------------------------------------------------------
# insert new request
$q = "DELETE FROM users_friends_requests WHERE (sent = ? AND got = ?) OR (sent = ? AND got = ?)";
$delete_friend_request = $THQ->insert($q, [$my->uid, $user_id, $user_id, $my->uid], true);

if (!$delete_friend_request->status) {
  $return->message = get_return_message_with(5);
  exit(json_encode($return));
}

$return->status = true;
$return->action = 'cancel_request';
$return->message = get_return_message_with(6);

exit(json_encode($return));


function get_return_message_with(int $code)
{
  if ($code == 1) return 'Something is wrong with this friendrequest!';
  if ($code == 2) return 'You are friends with this user!';
  if ($code == 3) return 'This user does not exist!';
  if ($code == 4) return 'This user does not want to receive friend-requests!';
  if ($code == 5) return 'Friendrequest could not been canceled, try again!';
  if ($code == 6) return 'Friendrequest has been canceled!';
}
