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
            <p class="ttup">Choose your Emoji!</p>
            <p class="ttup mr18"><span class="material-icons-round md-24">expand_more</span></p>
        </div>
    </label>

    <div>

        <?php

        $files = scandir('https://icons.thinkquotes.de/openmoji/');
        foreach ($files as $file) {

        ?>

            <img src="https://icons.thinkquotes.de/openmoji/<?php echo $file; ?>">

        <?php

        }

        ?>

    </div>

</div>



<?php

// foot section
include_once "./assets/templates/global/footer.php";

?>