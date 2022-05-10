<?php

if (!$is_page) header(NOT_FOUND);

$its_me = false;

# check for valid getting username
if (empty($_GET['username'])) header(NOT_FOUND);
if (!preg_match("/^[a-zA-Z0-9_\-]+$/", $_GET['username'])) header(NOT_FOUND);

# variablize the username
(string) $username = $_GET['username'];

# select current user for profile
$query = "SELECT *, users.id AS uid, users_settings.id AS usid FROM users, users_settings WHERE users.id = users_settings.uid AND BINARY users.username = ? LIMIT 1";
$get_user = $system->select($pdo, $query, [$username], false);

# validate user exists
if ($get_user->stmt->rowCount() < 1) header(NOT_FOUND);

# fetch user's data
$user = $get_user->fetch;

# tell php its profile of current_user, if it is
if ($my->uid && $user->uid == $my->uid) $its_me = true;

# nobody should be able to visit the archive of another user. They are only permitted
# to the owner. Check for that
if ($page == "profiles:archive" && !$its_me) header(NOT_FOUND);

# friends
$fr = $friends->getFriends($user->id);
$frofr = $friends->getFriendsOfFriends($user->id);
