<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// set JSON content type
header('Content-Type: application/json; charset=utf-8');

// TODO: #19 use system execution function and rewrite whole "favorite" script

if (
    !empty($_POST["qid"])
    && LOGGED
) {

    $qid = $_POST["qid"];
    $uid = UID;

    // check if quote exists
    $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ?");
    $getQuote->execute([$qid]);

    if ($getQuote->rowCount() > 0) {

        // fetch quote information
        $quote = $getQuote->fetch();

        // get the upvotes count of quote
        $sum = $quote->upvotes;

        // check if faved
        $getQuoteFavorite = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ?");
        $getQuoteFavorite->execute([$qid, $uid]);

        // * start mysql transaction
        $pdo->beginTransaction();

        if ($getQuoteFavorite->rowCount() > 0) {

            // fave exists
            $getQuoteFavoriteDeleted = $getQuoteFavorite->fetch();
            $success_output = "0";
            $setFavorite = "0";

            if ($getQuoteFavoriteDeleted->deleted == "1") {

                // fave quote
                $setFavorite = '0';
                $success_output = '1';
            } else {

                // unfave quote
                $setFavorite = '1';
                $success_output = '2';
            }

            $quoteAction = $pdo->prepare("UPDATE quotes_favorites SET deleted = ? WHERE qid = ? AND uid = ?");
            $quoteAction->execute([$setFavorite, $qid, $uid]);
        } else {

            // add new fave
            $quoteAction = $pdo->prepare("INSERT INTO quotes_favorites (qid, uid) VALUES (?,?)");
            $quoteAction->execute([$qid, $uid]);
            $success_output = '1';
        }

        // set base sum
        $newSum = $sum;

        // calculate new sum of upvotes
        if ($success_output == "1") {

            $newSum = $sum + 1;
            $return->message = "Added to your favorite's library";
        } else if ($success_output == "2") {

            $return->message = "Removed from your favorite's library";
            $newSum = $sum - 1;
        }

        // update sum
        $updateQuotesFavorites = $pdo->prepare("UPDATE quotes SET upvotes = ? WHERE id = ?");
        $updateQuotesFavorites->execute([$newSum, $qid]);


        if ($quoteAction && $updateQuotesFavorites) {

            $pdo->commit();

            $return->message = $return->message;
            $return->state = $success_output;
            $return->status = true;

            exit(json_encode($return));
        } else {

            $pdo->rollback();
            exit(json_encode($return));
        }
    } else {
        exit(json_encode($return));
    }
} else {
    exit(json_encode($return));
}
