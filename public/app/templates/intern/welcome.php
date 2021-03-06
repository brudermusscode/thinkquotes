<?php

$is_page = true;
$page = "intern";

// mysql database
require_once $_SERVER['DOCUMENT_ROOT'] . "/config/init.php";

// Head section
include_once TEMPLATES . "/global/head.php";
include_once TEMPLATES . "/global/header.php";

?>


<div id="main" class="wpx--intern">

    <div class="intern--outer">

        <div class="section-label mt12">
            <p class="tac">How to help you?</p>
        </div>

        <div class="search-bar">
            <div class="sb-inr">
                <div class="icon has-bg left">🍃</div>
                <div class="input">
                    <input type="text" placeholder="Searching for help will soon be implemented!" />
                </div>
                <div class="icon right clickable">➜</div>
            </div>
        </div>
        <?php

        $getInternSections = $pdo->prepare("SELECT * FROM intern_main_sections ORDER BY id");
        $getInternSections->execute();

        $countSections = $getInternSections->rowCount();
        $counter = 0;

        foreach ($getInternSections as $section) {

            $counter++;

        ?>



            <div class="mb42">

                <label for="quotes" class="posrel mb24">
                    <div class="label-inr">
                        <p class="ttup"><?php echo $section->title; ?></p>
                        <p class="ttup mr18">
                            <i class="ri-arrow-down-s-line std"></i>
                        </p>
                    </div>
                </label>

                <?php

                $getInternSectionsCards = $pdo->prepare("SELECT *, url AS iurl FROM intern_main_cards WHERE sid = ?");
                $getInternSectionsCards->execute([$section->id]);

                foreach ($getInternSectionsCards as $card) {

                ?>

                    <a href="<?php echo $url->intern; ?>/<?php echo $card->iurl; ?>">
                        <div class="element <?php if ($card->disabled) echo "disabled"; ?>">
                            <div class="render" style="background:url(<?php echo IMAGE; ?>/<?php echo $card->image; ?>) top right / cover no-repeat;">
                                <img onload="fadeInVisOpaBg($(this).parents().eq(1))" src="<?php echo IMAGE; ?>/<?php echo $card->image; ?>">
                            </div>

                            <div class="ud-inr">
                                <div class="inr-outer">
                                    <div class="tar">
                                        <p class="tac" style="background:<?php echo $card->icon_color; ?>;position:absolute;top:-1px;right:-1px;height:52px;width:52px;border-radius: 0 0 0 12px;">
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

            </div>
        <?php } ?>
    </div>

</div>


<?php

// foot section
include_once TEMPLATES . "/global/footer.php";

?>