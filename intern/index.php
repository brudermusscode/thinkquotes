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

    <div class="pb32" style="margin:20px auto 0;width: calc(100% - 48px);max-width: 1230px;color: var(--colour-light);font-size: 2em;font-weight: 400;text-shadow: 0 1px 2px rgba(0, 0, 0, 0.24);">
        <p class="tac">How to help you?</p>
    </div>

    <div class="intern--outer">

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

            $getInternSectionsCards = $pdo->prepare("SELECT * FROM intern_main_cards WHERE sid = ?");
            $getInternSectionsCards->execute([$section->id]);

            foreach ($getInternSectionsCards as $card) {

            ?>

                <a href="<?php echo $main["internurl"]; ?>/<?php echo $card->url; ?>">
                    <div class="element">
                        <div class="render" style="background:url(<?php echo $main["imageurl"]; ?>/<?php echo $card->image; ?>) top right / cover no-repeat;">
                            <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo $main["imageurl"]; ?>/<?php echo $card->image; ?>">
                        </div>

                        <div class="ud-inr">
                            <div class="inr-outer">
                                <div class="tar">
                                    <p class="tac rd6" style="background:<?php echo $card->icon_color; ?>;position:absolute;top:12px;right:12px;height:48px;width:48px;">
                                        <i class="material-icons-round md-24 align-mid-vert"><?php echo $card->icon; ?></i>
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
                    <span style="color:white;text-shadow: 0 1px 2px rgba(0 0 0 / 24%);" class="material-icons-round md-42">keyboard_arrow_down</span>
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