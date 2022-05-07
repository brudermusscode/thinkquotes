<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$pdo->beginTransaction();

if (isset($_POST) && $isLoggedIn) {

    $validSettings = [
        'show_profile',
        'show_profile_favorites',
        'send_friendrequests'
    ];
    $validValues = [
        'all',
        'friends',
        'friendsoffriends',
        'nobody'
    ];

    $showProfile = $my->show_profile;
    $showProfileFavorites = $my->show_profile_favorites;
    $sendFriendrequests = $my->send_friendrequests;

    // handle show_profile
    if (isset($_POST["show_profile"]) && in_array($_POST["show_profile"], $validValues)) {
        $showProfile = $_POST["show_profile"];
    }

    // handle show_profile_favorites
    if (isset($_POST["show_profile_favorites"]) && in_array($_POST["show_profile_favorites"], $validValues)) {
        $showProfileFavorites = $_POST["show_profile_favorites"];
    }

    // handle send_friendrequests
    if (isset($_POST["send_friendrequests"]) && in_array($_POST["send_friendrequests"], $validValues) && $_POST["send_friendrequests"] !== 'friends') {
        $sendFriendrequests = $_POST["send_friendrequests"];
    }

    // update users settings
    $update = $pdo->prepare("UPDATE users_settings SET show_profile = ?, show_profile_favorites = ?, send_friendrequests = ? WHERE uid = ?");
    $update->execute([$showProfile, $showProfileFavorites, $sendFriendrequests, $my->id]);

    if ($update) {

        $pdo->commit();
        exit('1');
    } else {

        $pdo->rollback();
        exit('0');
    }
} else {
    exit('0');
}
