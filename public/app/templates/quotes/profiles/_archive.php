<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

if (!isset($_POST["page"], $_POST["limit"], $_POST['uid']))
  exit('2');

# make sure the page is a string which is kind of unnecessary
(string) $page = $_POST['page'];
(int) $limit = $_POST['limit'];
(int) $userid = $_POST['uid'];

# make sure the limit count is an int
if (!is_numeric($limit)) exit('Huh?');
if (!is_numeric($userid)) exit('Huh?');

# variabilize
$query_limit = round($limit);

# get quotes
$query =
  # select * and rewrite id's of each join
  # TODO: consider changing foreign_key to actual names of tables for better readability
  "SELECT *, q.id qid, u.id uid, qa.id aid, qs.id sid
  -- basics from quotes
  FROM quotes q
  -- we need user information
    JOIN users u on u.id = q.uid
  -- we need quotes author
    JOIN quotes_authors qa on qa.id = q.aid
  -- we need quotes sources
    JOIN quotes_sources qs on qs.id = q.sid
  WHERE q.deleted = true
  -- select current profile's user
  AND u.id = ?
  -- shouldn't be draft
  AND q.is_draft = false
  -- order by the timestamp, no need for upvotes
  ORDER BY q.timestamp
  -- limitting through value from html attribute data-json
  DESC LIMIT ?";
$select_quotes = $THQ->select($pdo, $query, [$userid, $query_limit], true);

?>

<div data-element="quote:grid" class="inr grid">

  <?php

  # no quotes content
  if ($select_quotes->stmt->rowCount() < 1) {

    include TEMPLATES . "/quotes/_empty.php";
  } else {

    # querry all quotes
    foreach ($select_quotes->fetch as $elementInclude) {

      $pure = false;

      # include quote card
      include TEMPLATES . "/quotes/_quote.php";
    }
  }

  ?>

  <div style="display:block;visibility:hidden;height:12em;width:100%;"></div>

</div>