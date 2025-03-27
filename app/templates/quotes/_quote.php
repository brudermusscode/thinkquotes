<?php

use Bruder\Model\Quote;
use Bruder\Model\Topic;

/**
 *  @var Quote
 */

/**
 * @var bool
 */
$_include_topics ??= true;
$_include_author ??= true;

?>

<box-model quote data-id="<?php echo $Quote->id; ?>" rounded>
  <div p24 fl fldircol gap=smol>

    <div hide-puremode fl alic gap=smol>
      <p text dno><?php echo "#" . $Quote->id; ?></p>
      <div fl alic gap=smoler slighter>
        <i text bold stdplus class="si-quote"></i>
        <p text smolplus bold>Quote</p>
      </div>
    </div>

    <p mb=smol mt=smol quote-content text midler><?php echo htmlspecialchars_decode($Quote->text); ?></p>

    <div hide-puremode class="topics" mb=smol fl alic gap=smoler flex-wrap=wrap>
      <?php

      /**
       * @var ?Topic
       */
      $Topics = $Quote->topics;

      if ($_include_topics) {
        if ($Topics->count()) {

          /**
           * @var int
           */
          $current_topic = 0;

          foreach ($Topics as $Topic) {

            /**
             * Only show 3 topics.
             */
            if ($current_topic >= 3)
              break;

            /**
             * Increase topic counter.
             */
            $current_topic++;

      ?>

            <a href="/topic/<?php echo $Topic->id; ?>">
              <div text smolplus clickable background=light-green color=dark-green pv4 ph8 rounded=smol>
                <?php echo $Topic->name; ?>
              </div>
            </a>

          <?php

          }
        } else { ?>

          <div disabled text smolplus background=slighter pv4 ph8 rounded=smol clickable>
            <i class="si-plus"></i>
            Suggest topics
          </div>

        <?php } // end if $Topics-count() else
        ?>
      <?php } // end if $_include_topics
      ?>
    </div>

    <?php if ($_include_author) { ?>
      <a href="<?php echo "/author/" . $Quote->author->id; ?>">
        <div mr=smol fl jucend alic lh gap=smol>
          <i slighter text bold class="si-info-circle"></i>
          <p quote-author text midler bold><?php echo $Quote->author->name; ?></p>
        </div>
      </a>
    <?php } ?>

    <div hide-puremode fl jucsb aliend gap mt=smol>
      <div fl alic gap=smoler>
        <mbutton has-tooltip=bottom material circled icon-only size=smol background=slighter hoverable>
          <i style="margin-left:-.2em;" class="si-share"></i>
          <div ttooltip>
            Teilen
          </div>
        </mbutton>
      </div>

      <?php

      /**
       * @var ?Vote
       */
      $CurrentVote = $current_user->has_voted_for($Quote);

      /**
       * @var string
       */
      $vote_button_action_up =
        $CurrentVote?->vote_type === 1
        ? "vote/remove"
        : (
          $CurrentVote?->vote_type === -1
          ? "vote/edit"
          : "vote/create"
        );

      /**
       * @var string
       */
      $vote_button_action_down =
        $vote_button_action_up === "vote/remove"
        ? "vote/edit"
        : (
          $vote_button_action_up === "vote/edit"
          ? "vote/remove"
          : "vote/create"
        );

      ?>

      <div votes <?php echo $CurrentVote ? "data-vote-id='$CurrentVote->id'" : ""; ?> class=tools fl alic gap=smol+>
        <mbutton vote-positive data-vote-type="1"
          <?php
          echo $CurrentVote?->vote_type === 1
            ? "active"
            : "";
          ?>
          <?php
          echo "request-do='$vote_button_action_up'";
          ?>
          circled material icon-only size=smol>
          <i color=slight text stdplus class="si-arrow-up"></i>
        </mbutton>

        <?php

        /**
         * @var int
         */
        $vote_count = $Quote->vote_count();

        /**
         * @var string
         */
        $vote_count_color = $vote_count > 0
          ? "green"
          : (
            $vote_count < 0
            ? "red"
            : "dynamic"
          );

        ?>

        <p vote-count text std slight bold color=<?php echo $vote_count_color; ?>><?php echo $vote_count; ?></p>

        <mbutton vote-negative data-vote-type="-1"
          <?php
          echo $CurrentVote?->vote_type === -1
            ? "active"
            : "";
          ?>
          <?php
          echo "request-do='$vote_button_action_down'";
          ?>
          circled material icon-only size=smol>
          <i color=slight text stdplus class="si-arrow-down"></i>
        </mbutton>
      </div>
    </div>
  </div>
</box-model>