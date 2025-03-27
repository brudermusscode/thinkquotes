<?php

use Bruder\Http\Request;
use Bruder\Model\Author;
use Bruder\Model\Quote;
use Bruder\Model\Topic;

/**
 * @var ?int
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * @var string
 */
$topics = filter_input(INPUT_GET, "topics", FILTER_SANITIZE_SPECIAL_CHARS);

/**
 * @var ?Topic
 */
$Author = Author::find($id);

/**
 * Id is set?
 */
if (!$id || !$Author)
  include TEMPLATE . "/errors/invalid_request.php";
else {

  /**
   * Sanitize topics.
   * @var ?array
   */
  $topic_ids =
    $topics && Request::get_is_array_of_ints($topics)
    ? explode(",", $topics)
    : null;

  /**
   * @var ?Topic
   */
  $Topics =
    $topic_ids
    ? Topic::whereIn("id", $topic_ids)->get()
    : null;

  /**
   * @var ?Quote
   */
  $Quotes = $Author->quotes()
    ->when($Topics, function ($q) use ($topic_ids) {
      $q->whereHas("topics", function ($q2) use ($topic_ids) {
        $q2->whereIn("topics.id", $topic_ids);
      });
    })
    ->orderByRaw("loves - hates DESC")
    ->limit(30)
    ->get();

?>



  <header author scroll-manipulated fl fldircol gap jucsb>
    <div fl>
      <a href="/">
        <mbutton material circled icon-only background=transparent size=std hoverable>
          <i class="si-arrow-left"></i>
        </mbutton>
      </a>
    </div>

    <div fl fldircol gap=smol>
      <p author-name text wider bold><?php echo $Author->name; ?></p>
      <div fl gap=smol>
        <mbutton material size=std has-icon=left outlined background=transparent hoverable>
          <i class="si-share"></i>
          Author teilen
        </mbutton>
      </div>
    </div>
  </header>



  <div content-width=wider style=margin-top:13.2em; fl gap=mid alistart>
    <div fl gap=smol mb=smol>
      <?php

      if ($Topics)
        foreach ($Topics as $Topic) {

      ?>

        <mbutton active material has-icon=left size=std background=slighter hoverable>
          <i class="si-minus"></i>
          <?php echo htmlspecialchars_decode($Topic->name); ?>
        </mbutton>

      <?php

        }

      ?>
    </div>

    <?php

    /**
     * @var Topic
     */
    $HotTopics = $Author->topics()
      ->limit(3)
      ->get();

    ?>


    <div fl fldircol gap style=min-width:18em;position:sticky;top:2.4em;>
      <div fl fldircol gap=smol+>
        <p text stdplus trimt><strong>Themen</strong> von <?php echo $Author->name; ?></p>

        <div fl fldircol gap=smoler>
          <?php foreach ($HotTopics as $key => $Topic) { ?>
            <a href="<?php echo "/topic/$Topic->id"; ?>">
              <mbutton material has-icon=right size=std background=dynamic hoverable rounded>
                <div fl alic jucsb w100>
                  <div fl alic jucsb gap=smol w100 mr8>
                    <p text><?php echo $Topic->name; ?></p>
                  </div>
                  <i class="si-chevron-right"></i>
                </div>
              </mbutton>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>

    <div fl fldircol gap style=margin-top:-4.8em;>
      <?php

      foreach ($Quotes as $Quote) {
        /**
         * @var bool
         */
        $_include_topics = $Topics ? false : true;
        $_include_author = false;

        include TEMPLATE . "/quotes/_quote.php";
      }

      ?>
    </div>

    <div style=min-width:18em;></div>
  </div>

<?php

} // end if !$id || !$Topic
