<?php

$itsMe = false;

if (isset($_GET["page"], $_GET["userid"], $is_page)) {

    // define valid subpages
    $validPages = [
        "profile",
        "favorites",
        "archive"
    ];

    $subpage = $collection->only($_GET["page"], "let");
    $u = $collection->only($_GET["userid"], "num");

    // check user exists
    $getUser = $pdo->prepare("
        SELECT *, users.id AS uid, users_settings.id AS usid 
        FROM users, users_settings 
        WHERE users.id = users_settings.id 
        AND users.id = ?
    ");
    $getUser->execute([$u]);

    if ($getUser->rowCount() > 0 && in_array($subpage, $validPages)) {

        // check if user is me
        if (LOGGED) {
            if ($u == UID) {
                $itsMe = true;
            }
        }
        // fetch user information
        $user = $getUser->fetch();
    } else {
        header("location: ../../404");
    }
} else {
    header("location: ../../404");
}
