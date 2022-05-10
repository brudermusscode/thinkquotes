<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (empty($_REQUEST["qid"])) exit(false);

(int) $qid = $_REQUEST["qid"];

// get quote
$query = "SELECT *,
  quotes.id AS qid,
  users.id AS uid,
  quotes_authors.id AS aid,
  quotes_sources.id AS sid
  FROM quotes, users, quotes_authors, quotes_sources
  WHERE quotes.uid = users.id
  AND quotes.aid = quotes_authors.id
  AND quotes.sid = quotes_sources.id
  AND quotes.id = ?
  LIMIT 1";
$get_quote = $system->select($pdo, $query, [$qid], false);

// fetch quote
$elementInclude = $get_quote->fetch;

?>

<popup-module>
  <div class="inr">

    <label for="popup-module" class="mb32">
      <div class="label-inr light">
        <p><strong style="display:inline;"><?php if ($elementInclude->deleted) echo "Unarchive";
                                            else echo "Archive"; ?></strong> quote</p>
      </div>
    </label>

    <div class="input">
      <div class="pulse"></div>

      <?php

      // set pure to true for pure quote content without dropdown actions
      $pure = true;

      // include quote element
      include_once TEMPLATES . "/quotes/_quote.php";

      ?>
    </div>
  </div>
</popup-module>

<steps>
  <form method="POST" data-form="quotes:archive" action>
    <div class="steps-inr">

      <div class="description disfl fldirrow">
        <p class="mr12">
          <i class="ri-information-fill small"></i>
        </p>
        <p class="trimt" here>Are you sure?</p>

        <div class="cl"></div>
      </div>

      <div class="tools">
        <div class="disfl fldirrow">
          <div>

            <input type="hidden" name="qid" value="<?php echo $qid; ?>" />

            <hellofresh data-action="quotes:archive" class="hellofresh hover-shadow shadowed green rd12 icon-only mr12 posrel">
              <div class="c-ripple js-ripple">
                <span class="c-ripple__circle"></span>
              </div>
              <p class="lt posabs alignmiddle">
                <i class="ri-check-line std"></i>
              </p>

              <div class="cl"></div>
            </hellofresh>

          </div>
        </div>
      </div>

      <div class="cl"></div>
    </div>
  </form>
</steps>

<script class="dno">
  $(() => {
    setTimeout(() => {

      let $popupModule = $(document).find("popup-module");
      let $steps = $(document).find("steps");

      $popupModule.addClass("active");
      $steps.addClass("active");
    }, 750);
  });
</script>