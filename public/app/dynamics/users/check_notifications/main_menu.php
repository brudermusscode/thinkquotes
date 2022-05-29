<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (!LOGGED) exit(json_encode($return));

$pdo->beginTransaction();

# update user-settings
$q = "UPDATE users_settings SET checked_friend_requests = true WHERE uid = ?";
$update_users_settings = $THQ->update($pdo, $q, [$my->uid], true);

if (!$update_users_settings->status) exit(json_encode($return));

$pdo = NULL;

# reset session data
$my = $sign->resetSession();

# create new return object
$return->status = true;
$return->message = '';

# all done, exit out
exit(json_encode($return));
