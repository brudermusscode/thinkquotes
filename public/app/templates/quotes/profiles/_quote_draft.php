<?php

if (!isset($elementInclude)) exit('Nothing here but us chickens');

$draft = true;

// get categories
$query = "SELECT category_name
  FROM quotes_categories qc
    JOIN quotes_categories_used qcu ON qcu.cid = qc.id
  WHERE qcu.qid = ?
  ORDER BY qcu.id
  DESC LIMIT 3";
$get_quotes_categories = $THQ->select($pdo, $query, [$elementInclude->qid], true);

?>

<quote data-element="quote" data-quote-id="<?php echo $elementInclude->qid; ?>" data-json='[{"qid":"<?php echo $elementInclude->qid; ?>"}]' class="fade-in <?php if ($is_favorized) echo 'loved'; ?>" <?php if ($elementInclude->deleted) echo "archived"; ?>>

  <div data-append="overlay" class="quote--outer mshd-1">

    <?php

    // quote heading tools should just be shown when user is logged in
    // and the pure mode is not enabled
    if (LOGGED) include TEMPLATES . "/quotes/_dropdown_menu.php"; ?>

    <div class="q-inr">
      <div data-react="function:quotes,edit,hide">

        <div class="author fw7 mb4">
          <p>
            <?php
            if (empty($elementInclude->aid)) echo 'NULL';
            else echo $elementInclude->author_name; ?>
          </p>
        </div>

        <div class="q-text">
          <p>
            <?php
            if (empty($elementInclude->quote_text)) echo '<span style="display:block;margin-top:8px;font-style:italic;color:rgba(0,0,0,.48);">No text added</span>';
            else echo $elementInclude->quote_text; ?>
          </p>
        </div>

        <div class="q-categories">

          <?php if ($get_quotes_categories->stmt->rowCount() > 0) { ?>
            <?php foreach ($get_quotes_categories->fetch as $cat) { ?>

              <div class="category-banner lt mt4" data-quote-category-id="<?php echo $cat->id; ?>" data-json='[{"cid","<?php echo $cat->id; ?>"}]'>
                <?php echo ucfirst($cat->category_name); ?>
              </div>

            <?php } ?>
          <?php } else { ?>
            <span style="font-style:italic;color:rgba(0,0,0,.48);">No categories added</span>
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
              <span style="">⭕️</span>
            </div>
          </div>

        </div>
      </div>

    <?php } ?>

  </div>

  <div style="width:100%;height:1.4em;visibility:hidden;"></div>
</quote>