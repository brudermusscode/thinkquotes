<?php

$is_page = true;
$page = "intern";
$subPage = "intern:team";
$pageTitle = "Team of Development";

// mysql database
require_once "../session/session.inc.php";

// Head section
include_once "../assets/templates/global/head.php";
include_once "../assets/templates/global/header.php";

?>

<div id="main" class="wpx--main">

    <?php include_once "../assets/templates/intern/header.tools.php"; ?>

    <div class="intern--outer">

        <div class="rt-content">
        </div>

        <div class="lt-content posrel">

            <div class="whole-line"></div>

        </div>
    </div>
</div>


<?php include_once "../assets/templates/global/footer.php"; ?>