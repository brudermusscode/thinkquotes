<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (empty($_POST["qid"]) || !LOGGED) exit(json_encode($return));

(int) $qid = $_POST["qid"];
(int) $user_id = UID;

// get quote by qid
$query = "SELECT * FROM quotes WHERE id = ?";
$get_quote = $system->select($pdo, $query, [$qid], false);

if ($get_quote->stmt->rowCount() < 1) return json_encode($return);

// get upvotes count of quote and store as (int)
(int) $quote_upvotes = $get_quote->fetch->upvotes;

// * start mysql transaction
$pdo->beginTransaction();

// check if faved
$query = "SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ?";
$get_quote_favorized = $system->select($pdo, $query, [$qid, $user_id], false);


if ($get_quote_favorized->stmt->rowCount() < 1) {

    # set 'added'-message
    $return->message = "Added to your library";

    # increase quote upvotes by 1
    $quote_upvotes = $quote_upvotes + 1;

    # insert new favorite entry for current user
    $query = "INSERT INTO quotes_favorites (qid, uid) VALUES (?,?)";
    $insert_quote_favorite = $system->insert($pdo, $query, [$qid, UID], false);

    # validate successful query execution
    if (!$insert_quote_favorite->status) exit(json_encode($return));
} else {

    # decrease quote upvotes by 1
    if ($get_quote_favorized->fetch->deleted == 0) {

        $quote_upvotes = $quote_upvotes - 1;
        $return->message = "Removed from your library";
    } else {

        # set 'added'-message
        $return->message = "Added to your library";
        $quote_upvotes = $quote_upvotes + 1;
    }

    # update quote favorized set deleted to either 0 or 1, depending on the previous state
    $query = "UPDATE quotes_favorites SET deleted = CASE WHEN deleted = true THEN false ELSE true END WHERE qid = ? AND uid = ?";
    $discard_quote_favorite = $system->update($pdo, $query, [$qid, UID], false);

    # validate successful query execution
    if (!$discard_quote_favorite->status) exit(json_encode($return));
}

# update quote's upvotes
$query = "UPDATE quotes SET upvotes = ? WHERE id = ? AND uid = ?";
$update_quote = $system->update($pdo, $query, [$quote_upvotes, $qid, UID], true);

if (!$update_quote->status) exit(json_encode($return));

$return->status = true;
$return->message = $return->message;
$return->upvotes = $quote_upvotes;

exit(json_encode($return));

// if ($getQuoteFavorite->rowCount() > 0) {

//     // fave exists
//     $getQuoteFavoriteDeleted = $getQuoteFavorite->fetch();
//     $success_output = "0";
//     $setFavorite = "0";

//     if ($getQuoteFavoriteDeleted->deleted == "1") {

//         // fave quote
//         $setFavorite = '0';
//         $success_output = '1';
//     } else {

//         // unfave quote
//         $setFavorite = '1';
//         $success_output = '2';
//     }

//     $quoteAction = $pdo->prepare("UPDATE quotes_favorites SET deleted = ? WHERE qid = ? AND uid = ?");
//     $quoteAction->execute([$setFavorite, $qid, $user_id]);
// } else {

//     // add new fave
//     $quoteAction = $pdo->prepare("INSERT INTO quotes_favorites (qid, uid) VALUES (?,?)");
//     $quoteAction->execute([$qid, $user_id]);
//     $success_output = '1';
// }

// // set base sum
// $newSum = $sum;

// // calculate new sum of upvotes
// if ($success_output == "1") {

//     $newSum = $sum + 1;
//     $return->message = "Added to your favorite's library";
// } else if ($success_output == "2") {

//     $return->message = "Removed from your favorite's library";
//     $newSum = $sum - 1;
// }

// // update sum
// $updateQuotesFavorites = $pdo->prepare("UPDATE quotes SET upvotes = ? WHERE id = ?");
// $updateQuotesFavorites->execute([$newSum, $qid]);
