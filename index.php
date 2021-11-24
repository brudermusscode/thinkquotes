<?php
$is_page = true;
$page = "index";

// mysql database
require_once "./session/session.inc.php";

// Head section
include_once "./assets/templates/global/head.php";
include_once "./assets/templates/global/header.php";

?>
<div id="main" class="wpx--main">

    <label class="posrel mb24">
        <div class="inr">
            <p class="ttup">All time favorites</p>
            <p class="ttup mr18"><span class="material-icons-round md-24">expand_more</span></p>
        </div>
    </label>

    <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"<?php echo $page; ?>","order":"upvotes","limit":"40","uid":"0"}]'>

        <div class="actual"></div>

        <?php include_once "./assets/dynamics/content/quotes-loading.php"; ?>

    </create-grid>

</div>



<?php

// foot section
include_once "./assets/templates/global/footer.php";

?>