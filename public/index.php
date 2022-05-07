<?php

$is_page = true;
$page = "index";

// require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

// Head section
include_once "app/templates/global/head.php";
include_once "app/templates/global/header.php";

?>

<div id="main" class="wpx--main">

    <label for="quotes" class="posrel mb24">
        <div class="label-inr">
            <p class="ttup">All time favorites</p>
            <p class="ttup mr18">
                <i class="ri-arrow-down-s-line std"></i>
            </p>
        </div>
    </label>

    <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"index","limit":"200"}]'>
        <div class="actual"></div>
        <?php include_once "app/templates/quotes/_loading.php"; ?>
    </create-grid>

</div>

<?php include_once "app/templates/global/footer.php"; ?>