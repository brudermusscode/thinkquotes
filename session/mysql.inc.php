<?php

include_once 'config.inc.php';

// try catch database connection
try {

    $dsn = 'mysql:host=' . $conf["host"] . ';dbname=' . $conf["db"] . ';charset=' . $conf["charset"];
    $pdo = new PDO($dsn, $conf["user"], $conf["pass"]);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    date_default_timezone_set('Europe/Berlin');

    return $pdo;
    exit();
} catch (PDOException $e) {

    echo "Bruder: " . $e->getMessage();
    exit();
}
