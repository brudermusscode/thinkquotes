<?php

use Bruder\Model\Quote;
use Bruder\Model\Topic;

/**
 * @var ?int
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * @var ?Topic
 */
$Topic = Topic::find($id);

/**
 * Id is set?
 */
if (!$id || !$Topic)
  include TEMPLATE . "/errors/invalid_request.php";
else {

  /**
   * @var ?Quote
   */
  $Quotes = $Topic->quotes()
    ->orderByRaw("loves - hates DESC")
    ->limit(30)
    ->get();

?>

  <div content-width=smol fl fldircol gap>

    <div fl gap=smol mb=smol>
      <a href="/">
        <mbutton active material has-icon=left size=std background=slighter hoverable>
          <i class="si-minus"></i>
          <?php echo htmlspecialchars_decode($Topic->name); ?>
        </mbutton>
      </a>
    </div>


    <?php

    foreach ($Quotes as $Quote) {
      /**
       * @var bool
       */
      $_include_topics = false;

      include TEMPLATE . "/quotes/_quote.php";
    }

    ?>

  </div>

<?php

} // end if !$id || !$Topic
