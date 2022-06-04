<?php

# get database connection class
include_once $_SERVER['DOCUMENT_ROOT'] . "/config/definitions.php";
include_once ROOT . "/public/app/models/Db.php";

# create new dataabase connection
$db = new Db;
$connect = $db->connectDatabase();

# store connection data in $pdo
$pdo = (object) $connect->connection;

# store data that were used to connect to the database
# in $pdoConnectionData
$pdoConnectionData = $connect->configuration;

# check if connection has been set, if not return
# the error generated by the connection function
if (!$pdo) {
    echo $pdo;
}