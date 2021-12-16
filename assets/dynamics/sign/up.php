<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$pdo->beginTransaction();

if (
    isset($_POST["username"], $_POST["mail"], $_POST["password"], $_POST["password2"], $_POST["captcha"])
    && $_POST["username"] !== ""
    && $_POST["mail"] !== ""
    && $_POST["password"] !== ""
    && $_POST["password2"] !== ""
    && $_POST["captcha"] !== ""
    && !$logged
) {


    $username = $_POST["username"];
    $mail = $_POST["mail"];
    $password = md5($_POST["password"]);
    $password2 = md5($_POST["password2"]);
    $captcha = $_POST["captcha"];
    $remoteaddress = $_SERVER["REMOTE_ADDR"];

    if (preg_match('/^[a-zA-Z0-9一-龯]+$/i', $username)) {

        if (strlen($username) <= 64 && strlen($username) > 1) {

            if ($password === $password2) {

                if (strlen($_POST["password"]) >= 8 && strlen($_POST["password"]) <= 32) {

                    $captchaResponse = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $conf["recaptcha_privatekey"] . "&response=" . $captcha . "&remoteip=" . $remoteaddress));

                    if ($captchaResponse->success) {

                        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                            // check on username
                            $getAllUsernames = $pdo->prepare("SELECT * FROM users WHERE uname = ?");
                            $getAllUsernames->execute([$username]);
                            $getAllUsernames->fetch();

                            // check on mail
                            $getAllMail = $pdo->prepare("SELECT * FROM users WHERE mail = ?");
                            $getAllMail->execute([$mail]);
                            $getAllMail->fetch();

                            if ($getAllUsernames->rowCount() < 1) {
                                if ($getAllMail->rowCount() < 1) {

                                    $remoteaddr = $_SERVER['REMOTE_ADDR'];
                                    $httpxfor = $login->get_client_ip();
                                    $key = $login->createString(64);

                                    // insert into users
                                    $insert_users = $pdo->prepare("INSERT INTO users (uname, mail, password, verified_key, su_remoteaddr, su_httpx) 
                                            VALUES (?,?,?,?,?,?)");
                                    $insert_users->execute([$username, $mail, $password, $key, $remoteaddr, $httpxfor]);

                                    // get new user id
                                    $newid = $pdo->lastInsertId();
                                    $token = $login->createString(64);
                                    $serial = $login->createString(64);

                                    // insert into users_settings
                                    $insert_users_settings = $pdo->prepare("INSERT INTO users_settings (uid) VALUES (?)");
                                    $insert_users_settings->execute([$newid]);

                                    // insert into users_tokens
                                    $insert_users_tokens = $pdo->prepare("INSERT INTO users_tokens (uid, token) VALUES(?,?)");
                                    $insert_users_tokens->execute([$newid, $token]);


                                    /*************************/
                                    /****** send mail ********/
                                    /*************************/


                                    $create_session = $pdo->prepare("INSERT INTO system_sessions (uid,token,serial,remoteaddr,httpx) VALUES (?,?,?,?,?)");
                                    $create_session->execute([$newid, $token, $serial, $remoteaddr, $httpxfor]);


                                    // check insertions
                                    if ($insert_users && $insert_users_settings && $insert_users_tokens && $create_session) {

                                        $pdo->commit();

                                        $login->createCookie($newid, $username, $token, $serial);
                                        $login->createSession($newid, $username, $token, $serial, "0", "quote");

                                        exit('9');
                                    } else {

                                        $pdo->rollback();
                                        exit('0');
                                    }
                                } else {
                                    exit('8');
                                } // Mail already registered
                            } else {
                                exit('7');
                            } // Username is taken
                        } else {
                            exit('6');
                        } // Wrong email format
                    } else {
                        exit('5');
                    } // Wrong captcha
                } else {
                    exit('4');
                } // Password too long or short
            } else {
                exit('3');
            } // Passwords are not matching
        } else {
            exit('2');
        } // username too long or too short
    } else {
        exit('1');
    } // invalid symbols: username
} else {
    exit('0a');
}
