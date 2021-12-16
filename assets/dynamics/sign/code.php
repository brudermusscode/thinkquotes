<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (
    isset(
        $_REQUEST["uid"],
        $_REQUEST["code1"],
        $_REQUEST["code2"],
        $_REQUEST["code3"],
        $_REQUEST["code4"]
    ) &&
    !empty($_REQUEST["uid"]) &&
    is_numeric($_REQUEST["code1"]) &&
    is_numeric($_REQUEST["code2"]) &&
    is_numeric($_REQUEST["code3"]) &&
    is_numeric($_REQUEST["code4"])
) {

    // variablize
    $serial = NULL;
    $uid = $_REQUEST["uid"];
    $code1 = $_REQUEST["code1"];
    $code2 = $_REQUEST["code2"];
    $code3 = $_REQUEST["code3"];
    $code4 = $_REQUEST["code4"];

    // chain code as one string
    $code = $code1 . $code2 . $code3 . $code4;

    // check if there's an account with that email
    $stmt = $pdo->prepare("
        SELECT *, users.id AS uid, users_authentications.id AS authId 
        FROM users, users_authentications, users_settings
        WHERE users.id = users_authentications.uid 
        AND users.id = users_settings.uid
        AND users_authentications.uid = ?
        AND users_authentications.authCode = ?
        LIMIT 3
    ");
    $stmt->execute([$uid, $code]);

    if ($stmt->rowCount() > 0) {

        // create serial & token for session
        $serial = (object) [

            "token" => $sign->createString(34),
            "serial" => $sign->createString(34),
            "uid" => $uid
        ];

        // start mysql transaction
        $pdo->beginTransaction();

        // fetch users information
        $stmt = $stmt->fetch();

        // create session with user information
        if ($sign->createSession($stmt, $serial)) {

            $return->status = true;
            $return->message = "You've been logged in my friend!";

            exit(json_encode($return));
        } else {
            $return->message = "Couldn't create a session";
            exit(json_encode($return));
        }
    } else {
        $return->message = "Are you sure you are signed up?";
        exit(json_encode($return));
    }
} else {
    $return->message = "Fill out all forms";
    exit(json_encode($return));
}
