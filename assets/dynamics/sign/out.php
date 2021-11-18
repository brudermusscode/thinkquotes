<?php

require_once "./../../../session/session.inc.php";


if (isset($_POST['logout'])) {

    unset($_SESSION);
    $login->logout();
    session_destroy();

    exit('1');
} else {

    exit('0');
}
