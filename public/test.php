<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

$uid = 0;
$username = "Hurensohn";

$query = "SELECT * FROM users LIMIT 3";

# ALL OR NOTHING
# $pdo->beginTransaction();

$stmt = $system->select($pdo, $query);

print_r($stmt->fetch);
