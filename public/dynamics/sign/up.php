<?php

// include session file
include_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set application header to JSON
header('Content-type: application/json');

// start validation process
if (
    isset($_POST["mail"]) &&
    !empty($_POST["mail"]) &&
    !LOGGED
) {

    // variablize
    $mail = $_REQUEST["mail"];

    // validate mail address
    if ($sign->validateMail($mail)) {

        // get remoteaddr and httpx
        $httpx = $sign->getRemoteAddress();
        $remoteaddr = $_SERVER['REMOTE_ADDR'];

        // start mysql transaction
        $pdo->beginTransaction();

        // insert new user
        $stmt = $pdo->prepare("INSERT INTO users (mail, remoteaddr, httpx) VALUES (?, ?, ?)");
        $stmt = $system->execute($stmt, [$mail, $remoteaddr, $httpx], $pdo, false);

        if ($stmt->status) {

            // get last inserted id for setting up
            // relation between user and settings
            $id = $stmt->lastInsertId;

            // insert users settings
            $stmt = $pdo->prepare("INSERT INTO users_settings (uid) VALUES (?)");
            $stmt = $system->execute($stmt, [$id], $pdo, false);

            if ($stmt->status) {

                // create authentication code
                $authCode = $sign->createCode(4);

                // insert authentication
                $stmt = $pdo->prepare("INSERT INTO users_authentications (uid, authCode) VALUES (?, ?)");
                $stmt = $system->execute($stmt, [$id, $authCode], $pdo, true);

                if ($stmt->status) {

                    // prepare mail body
                    $mailbody = file_get_contents($url->main . '/assets/templates/mail/signup.html');
                    $mailbody = str_replace('%code%', $authCode, $mailbody);

                    // send mail
                    $sendMail = $system->trySendMail($mail, "Welcome to ThinkQuotes!", $mailbody, $sendMail->header);

                    // set return status to true, we did it boys
                    $return->status = true;
                    $return->uid = $id;

                    // check if a mail with a code has been sent
                    if ($sendMail) {

                        $return->message = "A mail with an authentication code has been sent to <strong>" . $mail . "</strong>";
                    } else {

                        $return->message = "We couldn't send an email out of curious reasons. Please login with your new account and use the the code which will be send there";
                    }

                    // exit with JSON encoded $return
                    exit(json_encode($return));
                } else {
                    exit(json_encode($return));
                }
            } else {
                exit(json_encode($return));
            }
        } else {
            switch ($stmt->code) {
                case "23000":
                    $return->message = "Your mail address is in use already. If this is your account, sign in";
                    break;
                default:
                    break;
            }

            exit(json_encode($return));
        }
    } else {
        $return->message = "Your mail address is invalid";
        exit(json_encode($return));
    }
} else {
    $return->message = "Please fill out all fields";
    exit(json_encode($return));
}
