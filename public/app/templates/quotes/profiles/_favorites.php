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
  "SELECT *, q.id qid, u.id uid, qa.id aid, qs.id sid, qf.id fid
  -- basics from quotes
  FROM quotes q
  -- we need user information
    JOIN users u on u.id = q.uid
  -- we need quotes author
    JOIN quotes_authors qa on qa.id = q.aid
  -- we need quotes sources
    JOIN quotes_sources qs on qs.id = q.sid
  -- join quotes favorites
    JOIN quotes_favorites qf on qf.qid = q.id
  -- quotes should not be archived
  WHERE q.deleted = false
  -- quote favorite should not be in deleted state
  AND qf.deleted = false
  -- select current profile's user
  AND qf.uid = ?
  -- order by the timestamp, no need for upvotes
  ORDER BY q.upvotes
  -- limitting through value from html attribute data-json
  DESC LIMIT ?";

// $query = "SELECT *,
//   quotes_favorites.id AS fid,
//   quotes.id AS qid,
//   quotes_sources.id AS sid,
//   quotes_authors.id AS auid,
//   users.id AS uid,
//   users_settings.id AS usid
//   FROM quotes_favorites, quotes, quotes_sources, quotes_authors, users, users_settings
//   WHERE quotes_favorites.qid = quotes.id
//   AND quotes.sid = quotes_sources.id
//   AND quotes.aid = quotes_authors.id
//   AND quotes.uid = users.id
//   AND quotes.uid = users_settings.id
//   AND quotes_favorites.uid = ?
//   AND quotes_favorites.deleted = '0'
//   AND quotes.deleted = '0'
//   ORDER BY quotes.upvotes
//   DESC
//   LIMIT ?";
$select_quotes = $system->select($pdo, $query, [$userid, $query_limit], true);

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