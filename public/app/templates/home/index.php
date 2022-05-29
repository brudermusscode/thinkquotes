<?php

$is_page = true;
$page = "index";

// require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . "/config/init.php";

// Head section
include_once TEMPLATES . "/global/head.php";
include_once TEMPLATES . "/global/header.php";

?>

<div class="mb42 mshd-1" style=width:100vw;position:sticky;top:0;z-index:5;background:var(--colour-lila-200);>
    <label for="quotes" class="pt12 pb12">
        <div id="main" style="padding:0;">
            <div class="label-inr" style=line-height:2.2em;>
                <p class="ttup mr18 tac" style=background:rgba(0,0,0,.12);height:2.2em;width:2.2em;border-radius:50%;>
                    <i class="ri-user-smile-fill"></i>
                </p>
                <p class="ttup">All time favorites</p>
            </div>
        </div>
    </label>
</div>

<div id="main" class="wpx--main">
    <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"index","limit":"200"}]'>
        <div class="actual"></div>
        <?php include_once TEMPLATES . "/quotes/_loading.php"; ?>
    </create-grid>
</div>

<?php include_once TEMPLATES . "/global/footer.php"; ?>