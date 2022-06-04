<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST['quote_id'])) exit(NULL);

(int) $quote_id = $_POST['quote_id'];

# get quote
$q =
  "SELECT *, q.id qid, q.uid uid
    FROM quotes q
        JOIN users u on u.id = q.uid
        JOIN quotes_authors qa on qa.id = q.aid
        JOIN quotes_sources qs on qs.id = q.sid
    AND q.id = ?
    ORDER BY q.upvotes
    DESC LIMIT 1";
$get_quote = $THQ->select($pdo, $q, [$quote_id], true);

if (!$get_quote->status) {
  include_once TEMPLATES . "/quotes/_error.php";
  exit();
}

if (!$get_quote->stmt->rowCount() > 0) {
  include_once TEMPLATES . "/quotes/_error.php";
  exit();
}

?>


<popup-module>
  <div class="inr">

    <label for="popup-module" class="mb32">
      <div class="label-inr light">
        <p>Report this quote</p>
      </div>
    </label>

    <div class="input">
      <div class="pulse"></div>

      <?php

      $pure = true;

      foreach ($get_quote->fetch as $elementInclude) {

        include_once TEMPLATES . '/quotes/_quote.php';
      } ?>
    </div>

    <form data-form="quotes,report" method="POST">
      <div class="posrel mt32 mb32">

        <?php

        $query = "SELECT * FROM quotes_reports_categories";
        $get_quote_report_categories = $THQ->select($pdo, $query, [], true);

        ?>

        <label for="quotes" class="posrel mb12">
          <div class="label-inr">
            <p class="ttup mr18">
              <i class="ri-question-line"></i>
            </p>
            <p class="ttup">What reason?</p>
          </div>
        </label>

        <box-model class="normal rounded shadowed">
          <div class="bm-inr">
            <div data-structure="select" class="select-input dark">
              <div class="show-actual">
                <p class="lt">
                  Select one here...
                </p>
                <p class="rt icon">
                  <i class="ri-arrow-down-fill"></i>
                </p>

                <div class="cl"></div>
              </div>

              <dataset class="mshd-2 tran-all-cubic">
                <input type="hidden" name="report_reason" value="">

                <ul>

                  <?php foreach ($get_quote_report_categories->fetch as $c) { ?>

                    <li data-set="<?php echo $c->id; ?>">
                      <p><?php echo $c->category; ?></p>
                    </li>

                  <?php } ?>

                </ul>
              </dataset>
            </div>
          </div>
      </div>

      <div>
        <label for="quotes" class="posrel mb12">
          <div class="label-inr">
            <p class="ttup mr18">
              <i class="ri-chat-smile-2-line"></i>
            </p>
            <p class="ttup">Tell us more, if you like</p>
          </div>
        </label>

        <box-model class="normal rounded ovhid shadowed">
          <textarea name="report_comment" placeholder="Add a comment for the report..." style="border-radius:0;"></textarea>
        </box-model>

        <input type="hidden" name="quote_id" value="<?php echo $qid; ?>" />
      </div>
    </form>
  </div>
</popup-module>

<steps>
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
          <hellofresh data-action="function:quotes,report" class="hellofresh hover-shadow shadowed green rd12 icon-only mr12 posrel">
            <div class="c-ripple js-ripple">
              <span class="c-ripple__circle"></span>
            </div>
            <p class="lt posabs alignmiddle">
              <i class="ri-arrow-right-line std"></i>
            </p>

            <div class="cl"></div>
          </hellofresh>
        </div>
      </div>
    </div>

    <div class="cl"></div>
  </div>
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