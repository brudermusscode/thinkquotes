<?php

$is_page = true;
$page = "index";

// mysql database
require_once "mysql/connect.php";

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

    <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"index","order":"upvotes","limit":"200","uid":"0"}]'>
        <div class="actual"></div>
        <?php include_once "app/dynamics/content/quotes-loading.php"; ?>
    </create-grid>

</div>

<?php include_once "app/templates/global/footer.php"; ?>