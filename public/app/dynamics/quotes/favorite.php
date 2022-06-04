<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST["qid"]) || !LOGGED) exit(json_encode($return));

(int) $qid = $_POST["qid"];
(int) $user_id = $my->uid;

// get quote by qid
$query = "SELECT * FROM quotes WHERE id = ?";
$get_quote = $THQ->select($pdo, $query, [$qid], false);

if ($get_quote->stmt->rowCount() < 1) return json_encode($return);

// get upvotes count of quote and store as (int)
(int) $quote_upvotes = $get_quote->fetch->upvotes;

// * start mysql transaction
$pdo->beginTransaction();

// check if faved
$query = "SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ?";
$get_quote_favorized = $THQ->select($pdo, $query, [$qid, $user_id], false);


if ($get_quote_favorized->stmt->rowCount() < 1) {

    # set 'added'-message
    $return->message = "Added to your library";

    # increase quote upvotes by 1
    $quote_upvotes = $quote_upvotes + 1;

    # insert new favorite entry for current user
    $query = "INSERT INTO quotes_favorites (qid, uid) VALUES (?,?)";
    $insert_quote_favorite = $THQ->insert($query, [$qid, $my->uid], false);

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
    $discard_quote_favorite = $THQ->update($pdo, $query, [$qid, $my->uid], false);

    # validate successful query execution
    if (!$discard_quote_favorite->status) exit(json_encode($return));
}

# update quote's upvotes
$query = "UPDATE quotes SET upvotes = ? WHERE id = ? AND uid = ?";
$update_quote = $THQ->update($pdo, $query, [$quote_upvotes, $qid, $my->uid], true);

if (!$update_quote->status) exit(json_encode($return));

$return->status = true;
$return->message = $return->message;
$return->upvotes = $quote_upvotes;

exit(json_encode($return));
