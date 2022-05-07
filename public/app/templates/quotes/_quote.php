<?php

if (isset($elementInclude)) {

  $pure = $pure ?? false;

  // check if is favorite
  if (LOGGED) {
    $getFaved = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ? AND deleted = '0'");
    $getFaved->execute([$elementInclude->qid, UID]);

    $isFavorite = FALSE;
    if ($getFaved->rowCount() > 0) {
      $isFavorite = TRUE;
    }

    $myQuote = false;
    if ($elementInclude->uid === UID) {
      $myQuote = true;
    }
  }

  // get fave count
  $getAllFaves = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND deleted = '0'");
  $getAllFaves->execute([$elementInclude->qid]);

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

  <quote data-element="quote" data-quote-id="<?php echo $elementInclude->qid; ?>" data-json='[{"qid":"<?php echo $elementInclude->qid; ?>"}]' class="fade-in <?php if ($isFavorite) { ?>loved<?php } ?>" <?php if ($elementInclude->deleted) echo "archived"; ?>>

    <div data-append="overlay" class="quote--outer mshd-1">

      <?php

      // quote heading tools should just be shown when user is logged in
      // and the pure mode is not enabled
      if (LOGGED && !$pure) {

      ?>

        <div data-element="dropdown" class="posrel" travelhereboy data-react="function:quotes,edit,hide">
          <div class="q-top-tools">

            <?php

            // in addition, if the quote is archived, show special button
            // instead of the dropdown menu
            if ($elementInclude->deleted) {

            ?>

              <div class="sizing unarchive disfl fldirrow" data-action="popups:quotes,delete">
                <p class="pt4 mr4">
                  <i class="material-icons small">unarchive</i>
                </p>
                <p>Unarchive</p>
              </div>

            <?php

              // if it's not archived, show the dropdown menu with dynamic
              // content specified for each user
            } else {

            ?>

              <div class="sizing" data-action="dropdown:open">
                <p>
                  <i class="ri-arrow-down-s-line std"></i>
                </p>
              </div>

              <dropdown data-dropdown="header,usermenu" data-react="dropdown:open" class="mshd-2">
                <div class="dd-inr">
                  <ul>

                    <?php

                    // those tools should be shown if the quote belongs to
                    // the viewing user
                    if ($myQuote) { ?>

                      <li class="has-icon trimt" data-action="popup:quotes,edit">
                        <p>
                          <i class="ri-edit-circle-fill small"></i>
                        </p>
                        <p>Edit</p>
                      </li>

                      <li class="has-icon trimt archive" data-action="popups:quotes,delete">
                        <p class="icon">
                          <i class="material-icons small"></i>
                        </p>
                        <p class="text"></p>
                      </li>

                    <?php

                      // if it's not the quote of the viewing user, show the options
                      // beneath
                    } else {

                    ?>

                      <li class="has-icon trimt" data-action="popup:quotes,report">
                        <p>
                          <i class="ri-flag-2-fill small"></i>
                        </p>
                        <p>Report</p>
                      </li>

                    <?php } ?>

                  </ul>
                </div>
              </dropdown>

            <?php } ?>

          </div>
        </div>

      <?php } ?>

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
              <a href="/u/profile/<?php echo $elementInclude->uid; ?>">
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

    <?php

    // just show bottom distance if pure mode is not enabled
    if (!$pure) {

    ?>

      <div style="width:100%;height:1.4em;visibility:hidden;"></div>

    <?php } ?>

  </quote>

<?php

} else {
  exit(0);
}
