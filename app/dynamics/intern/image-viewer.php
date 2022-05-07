<?php

require_once "./../../../session/session.inc.php";

if (isset($_POST["imageid"])) {

    if (
        $_POST["imageid"] != ""
    ) {

        $imageid = $_POST["imageid"];

        // check if image exists
        $getUpdatesImage = $pdo->prepare("SELECT * FROM system_updates_images WHERE id = ? ORDER BY id DESC LIMIT 1");
        $getUpdatesImage->execute([$imageid]);

        if ($getUpdatesImage->rowCount() > 0) {

            // smth
        } else {
            exit("0");
        }
    } else {
        exit("0");
    }
}
