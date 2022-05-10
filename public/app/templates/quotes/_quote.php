<?php

use Google\Service\Analytics\IncludeConditions;

if (!isset($elementInclude)) exit('Nothing here but us chickens');

$pure = $pure ?? false;

$is_favorized = false;
$is_my_quote = false;

# anything that happens, if a user is signed in
if (LOGGED) {

  # find entry for favorite related to current user and this post
  $query = "SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ? AND deleted = '0'";
  $get_is_favorizes = $system->select($pdo, $query, [$elementInclude->qid, $my->uid], false);

  # check, if this quote is faved by the current signed in user
  if ($get_is_favorizes->stmt->rowCount() > 0) $isFavorite = true;

  # check if current user is owner of this quote
  if ($elementInclude->uid === $my->uid) $is_my_quote = true;
}

// get categories
$getCategories = $pdo->prepare("
    SELECT *
    FROM quotes_categories_used, quotes_categories
    WHERE quotes_categories_used.cid = quotes_categories.id
    AND quotes_categories_used.qid = ?
    ORDER BY quotes_categories_used.id
    DESC LIMIT 3
");
$getCategories->execute([$elementInclude->qid]);

?>

<quote data-element="quote" data-quote-id="<?php echo $elementInclude->qid; ?>" data-json='[{"qid":"<?php echo $elementInclude->qid; ?>"}]' class="fade-in <?php if ($is_favorized) echo 'loved'; ?>" <?php if ($elementInclude->deleted) echo "archived"; ?>>

  <div data-append="overlay" class="quote--outer mshd-1">

    <?php

    // quote heading tools should just be shown when user is logged in
    // and the pure mode is not enabled
    if (LOGGED && !$pure) include TEMPLATES . "/quotes/_dropdown_menu.php"; ?>

    <div class="q-inr">
      <div data-react="function:quotes,edit,hide">

        <div class="author fw7 mb4">
          <p><?php echo $elementInclude->author_name; ?></p>
        </div>

        <div class="q-text">
          <p><?php echo $elementInclude->quote_text; ?></p>
        </div>

        <div class="q-categories">

          <?php foreach ($getCategories->fetchAll() as $cat) { ?>

            <div class="category-banner lt mt4" data-quote-category-id="<?php echo $cat->id; ?>" data-json='[{"cid","<?php echo $cat->id; ?>"}]'>
              <?php echo ucfirst($cat->category_name); ?>
            </div>

          <?php } ?>

          <div class="cl"></div>

        </div>

      </div>
    </div>

    <?php

    // show bottom quote tools just if the user is logged in, the quote is not in
    // pure mode and it hasn't been archived
    if (
      LOGGED &&
      !$pure &&
      !$elementInclude->deleted
    ) {

    ?>

      <div class="tools">
        <div class="disfl fldirrow" style="padding:12px 32px;">

          <div style="margin-right:auto;" class="disfl fldirrow">
            <a href="/u/<?php echo $elementInclude->username; ?>">
              <div class="to-profile">
                <p><?php echo $elementInclude->username; ?></p>
              </div>
            </a>
          </div>

          <div style="margin-left:auto;" class="disfl flexdirrow">
            <div class="duo">
              <div data-action="function:quotes,favorite" class="lt uno love">
                <i class="material-icons small"></i>
              </div>
              <div class="lt duo-text">
                <p data-react="functions:quotes,favorite,count"><?php echo $elementInclude->upvotes; ?></p>
              </div>

              <div class="cl"></div>
            </div>
          </div>

        </div>
      </div>

    <?php } ?>

  </div>

  <?php if (!$pure) echo '<div style="width:100%;height:1.4em;visibility:hidden;"></div>'; ?>
</quote>