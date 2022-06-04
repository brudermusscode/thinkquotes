<?php
$is_page = true;
$page = "index";

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

// Head section
include_once TEMPLATES . "/global/head.php";
include_once TEMPLATES . "/global/header.php";

?>
<div id="main" class="wpx--main">

    <label class="posrel mb24">
        <div class="inr">
            <p class="ttup lt">Choose your Emoji!</p>
            <p class="ttup mr18 lt"><span class="material-icons md-24">expand_more</span></p>
            <div class="cl"></div>
        </div>
    </label>

    <div>

        <?php

        $files = scandir(ROOT . '/app/assets/icons/openmoji/');
        foreach ($files as $file) { ?>

            <div style="float:left;width:100px;text-align:center;background:white;margin:6px;border-radius:12px;padding:12px 1em;">
                <img style="height:32px;" src="<?php echo '/app/assets/icons/openmoji/' . $file; ?>">
                <p class="trimt"><?php echo $file; ?></p>
            </div>

        <?php } ?>

    </div>

</div>



<?php

// foot section
include_once TEMPLATES . "/global/footer.php";

?>