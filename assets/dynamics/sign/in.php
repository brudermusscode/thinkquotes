<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$pdo->beginTransaction();

if (
    isset($_POST["username"], $_POST["password"])
    && $_POST["username"] !== ""
    && $_POST["password"] !== ""
    && !$isLoggedIn
) {

    // serialize input
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    // check username or email exists
    $login_request = $pdo->prepare("
        SELECT * FROM users, users_settings 
        WHERE users.id = users_settings.uid 
        AND (users.uname = ? OR users.mail = ?)
    ");
    $login_request->execute([$username, $username]);

    if ($login_request->rowCount() > 0) {

        $log = $login_request->fetch();
        $logPassword = $log->password;


        // check password correct
        if ($password === $logPassword) {

            $id = $log->id;
            $username = $log->uname;
            $admin = $log->admin;
            $post_permissions = $log->post_permissions;
            $token = $login->createString(64);
            $serial = $login->createString(64);
            $remoteaddr = $_SERVER['REMOTE_ADDR'];
            $httpxfor = $login->get_client_ip();

            // check for existing session
            $getOldSession = $pdo->prepare("SELECT * FROM system_sessions WHERE uid = ?");
            $getOldSession->execute([$id]);
            $hasSession = FALSE;
            if ($getOldSession->rowCount() > 0) {
                $hasSession = TRUE;
            }

            // delete old records
            if ($hasSession) {

                $create_session = $pdo->prepare("UPDATE system_sessions SET uid = ?, token = ?, serial = ?, remoteaddr = ?, httpx = ? WHERE uid = ?");
                $create_session->execute([$id, $token, $serial, $remoteaddr, $httpxfor, $id]);
            } else {

                $create_session = $pdo->prepare("INSERT INTO system_sessions (uid,token,serial,remoteaddr,httpx) VALUES (?,?,?,?,?)");
                $create_session->execute([$id, $token, $serial, $remoteaddr, $httpxfor]);
            }

            $login->createCookie($id, $username, $token, $serial);
            $login->createSession($id, $username, $token, $serial, $admin, $post_permissions);

            if ($create_session) {

                $pdo->commit();
                exit('3');
            } else {

                $pdo->rollback();
                exit('0');
            }
        } else {
            exit('2');
        } // wrong password
    } else {
        exit('1');
    } // user doesn't exist 
} else {
    exit('0');
}
