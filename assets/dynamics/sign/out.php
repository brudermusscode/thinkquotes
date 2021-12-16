<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST['logout'])) {

    unset($_SESSION);
    $login->logout();
    session_destroy();

    exit('1');
} else {

    exit('0');
}
