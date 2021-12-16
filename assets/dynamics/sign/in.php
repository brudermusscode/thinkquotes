<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (
    isset($_REQUEST["mail"]) &&
    !empty($_REQUEST["mail"])
) {

    // variablize
    $inputmail = $_REQUEST["mail"];

    // validate e-mail address
    if ($sign->validateMail($inputmail)) {

        // check if there's an account with that email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = ?");
        $stmt->execute([$inputmail]);

        if ($stmt->rowCount() > 0) {

            // fetch users information for id
            $stmt = $stmt->fetch();
            $uid = $stmt->id;

            // create a code
            $code = $sign->createCode(4);

            // start ,ysql transaction
            $pdo->beginTransaction();

            // send code to that mail address
            $stmt = $pdo->prepare("INSERT INTO users_authentications (uid, authCode) VALUES (?, ?)");
            $stmt = $system->execute($stmt, [$uid, $code], $pdo, true);

            if ($stmt->status) {

                $return->status = true;
                $return->uid = $uid;
                $return->message = "Success! A code has been sent to your mail";

                exit(json_encode($return));
            } else {
                $return->message = "Mistakes must be done. That's what makes us human";
                exit(json_encode($return));
            }
        } else {
            $return->message = "Are you sure you are signed up?";
            exit(json_encode($return));
        }
    } else {
        $return->message = "That's not a mail";
        exit(json_encode($return));
    }
} else {
    $return->message = "Fill out all forms";
    exit(json_encode($return));
}
