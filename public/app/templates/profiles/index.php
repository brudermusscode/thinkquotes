<?php

$is_page = true;
$page = "profiles:index";

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

# include logic processing
include_once TEMPLATES . "/profiles/_logic.php";

# Head section
include_once TEMPLATES . "/global/head.php";
include_once TEMPLATES . "/global/header.php";

# * insert banner
include_once TEMPLATES . "/profiles/_banner.php";

# * insert menu
include_once TEMPLATES . "/profiles/_menu.php";

?>

<div id="main" class="wpx--main">

  <div class="mt24"></div>

  <label for="quotes" class="posrel mb24">
    <div class="label-inr">
      <p class="ttup">

        <?php

        if (LOGGED && $user->uid == $my->uid) {
          echo "Quotes you posted";
        } else {
          echo "Quotes by $user->username";
        }

        ?>

      </p>
      <p class="ttup mr18">
        <i class="ri-arrow-down-s-line std"></i>
      </p>
    </div>
  </label>

  <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"profiles:index","limit":"20","uid":"<?php echo $user->uid; ?>"}]'>
    <div class="actual"></div>
    <?php include_once TEMPLATES . "/quotes/_loading.php"; ?>
  </create-grid>

</div>

<?php

# foot section
include_once TEMPLATES . "/global/footer.php";

?>