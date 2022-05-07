<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

if (
  !isset($_POST["page"], $_POST["order"], $_POST["limit"], $_POST["uid"]) &&
  !filter_var($_POST["limit"], FILTER_VALIDATE_FLOAT)
) {
  exit('0');
}

# variabilize
$query_limit = round($_POST["limit"]);

# check user is me
$itsMe = FALSE;

# if user is logged in, set it's me to true
if (LOGGED) {
  if ($uid == UID) {
    $itsMe = TRUE;
  }
}

# get quotes
$getQuotes = $pdo->prepare(
  "SELECT *,
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
      DESC LIMIT ?"
);
$getQuotes->execute([$query_limit]);

?>

<div data-element="quote:grid" class="inr grid">

  <?php

  # no quotes content
  if ($getQuotes->rowCount() < 1) {

    include ROOT . "/app/templates/quotes/_empty.php";
  } else {

    # querry all quotes
    foreach ($getQuotes->fetchAll() as $elementInclude) {

      $pure = false;

      # include quote card
      include ROOT . "/app/templates/quotes/_quote.php";
    }
  }

  ?>

  <div style="display:block;visibility:hidden;height:12em;width:100%;"></div>

</div>