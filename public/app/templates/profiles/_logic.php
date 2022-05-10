<?php

if (!$is_page) {
  header("location: /404");
}

$its_me = false;

# check for valid getting username
if (empty($_GET['username'])) header('location: /404');
if (!preg_match("/^[a-zA-Z0-9_\-]+$/", $_GET['username'])) header('location: /404');

# variablize the username
(string) $username = $_GET['username'];

# select current user for profile
$query = "SELECT *, users.id AS uid, users_settings.id AS usid FROM users, users_settings WHERE users.id = users_settings.uid AND BINARY users.username = ? LIMIT 1";
$get_user = $system->select($pdo, $query, [$username], false);

# validate user exists
if ($get_user->stmt->rowCount() < 1) header('location: /404');

# fetch user's data
$user = $get_user->fetch;

# tell php its profile of current_user, if it is
if ($my->uid && $user->uid == $my->uid) $its_me = true;

# nobody should be able to visit the archive of another user. They are only permitted
# to the owner. Check for that
if ($page == "profiles:archive" && !$its_me) header('location: /404');

# friends
$fr = $friends->getFriends($user->id);
$frofr = $friends->getFriendsOfFriends($user->id);
