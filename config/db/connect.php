<?php

# get database connection class
include_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/definitions.php";
include_once ROOT . "/app/models/Db.php";

# create new dataabase connection
$db = new Db;
$db = $db->connectDatabase();

# store connection data in $pdo
$pdo = $db->connection;

# store data that were used to connect to the database
# in $pdoConnectionData
$pdoConnectionData = $db->configuration;

# check if connection has been set, if not return
# the error generated by the connection function
if (!$pdo) {
    echo $pdo;
}
