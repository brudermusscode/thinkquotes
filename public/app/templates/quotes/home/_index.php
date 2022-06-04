<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/init.php";

if (!isset($_POST["page"], $_POST["limit"]))
  exit('0');

# make sure the page is a string which is kind of unnecessary
(string) $page = $_POST['page'];
(int) $limit = $_POST['limit'];

# make sure the limit count is an int
if (!is_numeric($limit)) exit('Huh?');

# variabilize
$query_limit = round($limit);

# get quotes
$query =
  "SELECT *, q.id qid, q.uid uid
  FROM quotes q
    JOIN users u on u.id = q.uid
    JOIN quotes_authors qa on qa.id = q.aid
    JOIN quotes_sources qs on qs.id = q.sid
  WHERE q.deleted = false
  AND is_draft = false
  ORDER BY q.upvotes
  DESC LIMIT ?";
$select_quotes = $THQ->select($pdo, $query, [$query_limit], true);

?>

<div data-element="quote:grid" class="inr grid">

  <?php

  # no quotes content
  if ($select_quotes->stmt->rowCount() < 1) {

    include ROOT . "/public/app/templates/quotes/_empty.php";
  } else {

    # querry all quotes
    foreach ($select_quotes->fetch as $elementInclude) {

      $pure = false;

      # include quote card
      include ROOT . "/public/app/templates/quotes/_quote.php";
    }
  }

  ?>

  <div style="display:block;visibility:hidden;height:12em;width:100%;"></div>

</div>