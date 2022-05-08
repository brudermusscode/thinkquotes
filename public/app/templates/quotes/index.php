<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

if (!isset($_POST["page"], $_POST["limit"]))
  exit('0');

# make sure the page is a string which is kind of unnecessary
(string) $page = $_POST['page'];
(int) $limit = $_POST['limit'];

# make sure the limit count is an int
if (!filter_var($limit, FILTER_VALIDATE_INT)) exit('Huh?');

# variabilize
$query_limit = round($limit);

# get quotes
$query = "SELECT *,
      quotes.id AS qid,
      users.id AS uid,
      quotes_authors.id AS aid,
      quotes_sources.id AS sid
      FROM quotes, users, quotes_authors, quotes_sources
      WHERE quotes.uid = users.id
      AND quotes.aid = quotes_authors.id
      AND quotes.sid = quotes_sources.id
      AND quotes.deleted = '0'
      ORDER BY quotes.upvotes
      DESC LIMIT ?";
$select_quotes = $system->select($pdo, $query, [$query_limit], true);

?>

<div data-element="quote:grid" class="inr grid">

  <?php

  # no quotes content
  if ($select_quotes->stmt->rowCount() < 1) {

    include ROOT . "/app/templates/quotes/_empty.php";
  } else {

    # querry all quotes
    foreach ($select_quotes->fetch as $elementInclude) {

      $pure = false;

      # include quote card
      include ROOT . "/app/templates/quotes/_quote.php";
    }
  }

  ?>

  <div style="display:block;visibility:hidden;height:12em;width:100%;"></div>

</div>