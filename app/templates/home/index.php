<?php

use Bruder\Model\Quote;
use Bruder\Model\Topic;

/**
 * @var User $current_user
 */

/**
 * @var Quote
 */
$Quotes = Quote::with(["author", "topics", "votes"])
  ->orderByRaw("loves - hates DESC")
  ->limit(30)
  ->get();

/**
 * @var Topic
 */
$HotTopics = Topic::orderBy("quotes_count", "desc")
  ->limit(6)
  ->get();

/**
 * @var Topic
 */
$HottestTopic = $HotTopics->first();

?>

<div content-width=wider fl fldircol gap>
  <div fl gap=wide alistart posrel>


    <!--- CONTENT: LEFT --->
    <div fl fldircol gap style=min-width:18em;position:sticky;top:5.2em;>
      <div fl fldircol gap=smol+>
        <a href="<?php echo "/topic/$HottestTopic->id"; ?>">
          <box-model style="background:transparent url(/assets/images/18895384_6049549.svg) 100% 60% no-repeat;background-size:cover;" rounded clickable>
            <div fl jucsb alic p32 text-shadowed=min>
              <div fl fldircol jucc gap=smol color=light>
                <p text mid bold><?php echo $HottestTopic->name; ?></p>
                <p text smolplus><?php echo $HottestTopic->quotes_count; ?> quotes</p>
              </div>

              <mbutton material size=std circled icon-only color=light>
                <i class="si-arrow-right"></i>
              </mbutton>
            </div>
          </box-model>
        </a>
      </div>

      <div fl fldircol gap=smol+>
        <p text bold stdplus>Weitere Themen</p>

        <div fl fldircol gap=smoler>
          <?php foreach ($HotTopics as $key => $Topic) {

            /**
             * Display a different card for the hottest (1st) topic here.
             */
            if ($Topic->is($HottestTopic))
              continue;

          ?>
            <a href="<?php echo "/topic/$Topic->id"; ?>">
              <mbutton material has-icon=right size=std background=dynamic hoverable rounded>
                <div fl alic jucsb w100>
                  <div fl alic jucsb gap=smol w100 mr8>
                    <p text><?php echo $Topic->name; ?></p>
                    <div rounded=smol ph4 pv2 text smol background=light-pink color=dark><?php echo $Topic->quotes_count; ?></div>
                  </div>
                  <i class="si-chevron-right"></i>
                </div>
              </mbutton>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>


    <div fl fldircol gap>
      <div content fl fldircol gap>
        <?php

        foreach ($Quotes as $Quote) {
          include TEMPLATE . "/quotes/_quote.php";
        } // end foreach quotes

        ?>
      </div>
    </div>


    <div fl fldircol gap style=min-width:18em;position:sticky;top:5.2em;>
      &nbsp;
    </div>


  </div>
</div>

<div random-topics hidden>
  <?php

  /**
   * Include random topics but hide them, so that we can pick single
   * ones from it and insert it into the feed via JS.
   */
  include TEMPLATE . "/home/_random_topics.php"; ?>
</div>