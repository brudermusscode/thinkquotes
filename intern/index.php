<?php

$is_page = true;
$page = "intern";

// mysql database
require_once "../session/session.inc.php";

// Head section
include_once "../assets/templates/global/head.php";
include_once "../assets/templates/global/header.php";

?>


<div id="main" class="wpx--main">

    <div class="intern--outer">

        <div class="pb32 section-label">
            <p class="tac mt32 mb12" style="font-size:4em;">How to help you?</p>
        </div>

        <?php

        $getInternSections = $pdo->prepare("SELECT * FROM intern_main_sections ORDER BY id");
        $getInternSections->execute();

        $countSections = $getInternSections->rowCount();
        $counter = 0;

        foreach ($getInternSections as $section) {

            $counter++;

        ?>

            <div class="section-label">
                <p><?php echo $section->title; ?></p>
            </div>

            <?php

            $getInternSectionsCards = $pdo->prepare("SELECT *, url AS iurl FROM intern_main_cards WHERE sid = ?");
            $getInternSectionsCards->execute([$section->id]);

            foreach ($getInternSectionsCards as $card) {

            ?>

                <a href="<?php echo $url->intern; ?>/<?php echo $card->iurl; ?>">
                    <div class="element <?php if ($card->disabled) echo "disabled"; ?>">
                        <div class="render" style="background:url(<?php echo $url->img; ?>/<?php echo $card->image; ?>) top right / cover no-repeat;">
                            <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $url->img; ?>/<?php echo $card->image; ?>">
                        </div>

                        <div class="ud-inr">
                            <div class="inr-outer">
                                <div class="tar">
                                    <p class="tac rd6" style="background:<?php echo $card->icon_color; ?>;position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                        <i class="material-icons std align-mid-vert"><?php echo $card->icon; ?></i>
                                    </p>

                                    <div class="cl"></div>

                                    <div class="rt rd6" style="background:rgba(255,255,255,.64);padding:24px;">
                                        <p class="fw4 trimt" style="color:var(--colour-dark-500);text-shadow:0 0 4px white;"><?php echo $card->slogan; ?></p>
                                        <p class="fw6 trimt" style="color:var(--colour-dark);font-size:2em;text-shadow:0 0 4px white;line-height:1.1em;"><?php echo $card->title; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            <?php } ?>

            <div class="cl"></div>

            <?php if ($counter <= ($countSections - 1)) { ?>

                <div style="width:2.6em;margin:42px auto;">
                    <i style="color:white;text-shadow: 0 1px 2px rgba(0 0 0 / 24%);" class="material-icons large">keyboard_arrow_down</i>
                </div>

        <?php

            }
        }

        ?>

    </div>

</div>


<?php

// foot section
include_once "../assets/templates/global/footer.php";

?>