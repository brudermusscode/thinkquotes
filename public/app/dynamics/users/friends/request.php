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
  FROM users_friends_requests ufr
  WHERE (ufr.sent = ? AND ufr.got = ?)
  OR (ufr.sent = ? AND ufr.got = ?)
  LIMIT 1";
$get_friend_request = $THQ->select($pdo, $q, [$my->uid, $user_id, $user_id, $my->uid], false);

if (!$get_friend_request->status || !$get_friend_request->stmt->rowCount() < 1) {
  $return->message = get_return_message_with(1);
  exit(json_encode($return));
}

# check if friendship exists
$q =
  "SELECT id
  FROM users_friends uf
  WHERE uf.uid1 = CASE
    WHEN uf.uid1 = ?
      THEN ? AND uf.uid2 = ?
      ELSE ? AND uf.uid2 = ?
    END
  LIMIT 1";
$get_friends = $THQ->select($pdo, $q, [$my->uid, $user_id, $my->uid, $my->uid, $user_id], false);

if (!$get_friends->status || !$get_friends->stmt->rowCount() < 1) {
  $return->message = get_return_message_with(2);
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
# check if can send friendrequest
$allow_request = false;
$friend_of_friends = (array) $Friends->getFriendsOfFriends($user_id);

# check if user has permission to send friendrequest
switch ($get_user->fetch->send_friendrequests) {
  case "all":
    $allow_request = true;
    break;

  case "friendsoffriends":
    $allow_request = true;
    if (!in_array($my->uid, $friend_of_friends)) $allow_request = false;
    break;

  case 'none':
  default:
    $allow_request = false;
}

if (!$allow_request) {
  $return->message = get_return_message_with(4);
  exit(json_encode($return));
}

# ----------------------------------------------------------------
# start mysql transaction, all or nothing bro
$pdo->beginTransaction();

# ----------------------------------------------------------------
# insert new request
$q = "INSERT INTO users_friends_requests (sent, got) VALUES (?, ?)";
$insert_friend_request = $THQ->insert($q, [$my->uid, $user_id], false);

if (!$insert_friend_request->status) {
  $return->message = get_return_message_with(5);
  exit(json_encode($return));
}

# ----------------------------------------------------------------
# update and uncheck users settings friend requests
$q = "UPDATE users_settings SET checked_friend_requests = false WHERE uid = ?";
$update_users_settings = $THQ->insert($q, [$user_id], true);

if (!$update_users_settings->status) {
  $return->message = get_return_message_with(5);
  exit(json_encode($return));
}

# ----------------------------------------------------------------
$return->status = true;
$return->action = 'request';
$return->message = get_return_message_with(6);

exit(json_encode($return));


function get_return_message_with(int $code)
{
  if ($code == 1) return 'You already sent a request to that user!';
  if ($code == 2) return 'You are already firneds with that user!';
  if ($code == 3) return 'This user does not exist!';
  if ($code == 4) return 'This user does not want to receive friend-requests!';
  if ($code == 5) return 'Friendrequest could not been sent, try again!';
  if ($code == 6) return 'Friendrequest has been sent!';
}
