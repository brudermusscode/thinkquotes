<?php

require_once "./../../../session/session.inc.php";

if (isset($_POST["qid"]) && $_POST["qid"] !== "" && $logged) {

    $qid = $_POST["qid"];
    $guid = $my->id;

    // check quotes existence
    $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ? and uid = ?");
    $getQuote->execute([$qid, $guid]);

    if ($getQuote->rowCount() > 0) {

        $q = $getQuote->fetch();
        $categoryArray = [];

        $getCategories = $pdo->prepare("
            SELECT * 
            FROM quotes_categories_used, quotes_categories 
            WHERE quotes_categories_used.cid = quotes_categories.id
            AND quotes_categories_used.qid = ?
            ORDER BY quotes_categories_used.id
        ");
        $getCategories->execute([$q->id]);
        if ($getCategories->rowCount() > 0) {
            foreach ($getCategories->fetchAll() as $c) {
                $categoryArray[] = $c->category_name;
            }
        }

        exit(json_encode($categoryArray));
    } else {
        exit("0");
    }
} else {
    exit("0");
}
