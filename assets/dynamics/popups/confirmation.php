<?php

require_once "./../../../session/session.inc.php";

if (isset($_POST['a'], $_POST['b'], $_POST['c'], $_POST['d'], $_POST['e']) && $isLoggedIn) {

    $label = $_POST['a'];
    $icon = $_POST['b'];
    $text = $_POST['c'];
    $dataAction = $_POST['d'];
    $confirmationText = $_POST['e'];

    // handle json data
    if (isset($_POST['f'])) {
        $dataJSON = $_POST['f'];
    } else {
        $dataJSON = "";
    }

?>



    <popup-module class="pb62" style="max-width:360px;z-index:10;">

        <form data-form="sign:out">

            <div class="slideUp mshd-4 rd10" style="background-color:var(--colour-dark);">

                <label class="posrel">
                    <div class="inr" style="padding:24px 42px;">
                        <p class="fs24 lt ttup mr24 pt2" style="color:var(--colour-light);text-shadow:0 2px 6px rgba(0,0,0,.68);">
                            <?php echo $label; ?>
                        </p>

                        <div data-action="popup:close" class="close dark posabs align-mid-vert" style="right:32px;line-height:1;">
                            <p class="posabs alignmiddle"><span class="material-icons-round md24">close</span></p>
                        </div>

                        <div class="cl"></div>
                    </div>
                </label>

                <div class="inr posrel" style="z-index:1;padding:24px 48px 48px;">
                    <p class="posabs align-mid-horiz" style="color:var(--colour-light);">
                        <span class="material-icons-round md-62"><?php echo $icon; ?></span>
                    </p>
                    <p class="tac mt72" style="color:var(--colour-light);margin-bottom:8px;"><?php echo $text; ?></p>
                </div>

                <div class="submit">



                    <hellofresh data-action="<?php echo $dataAction; ?>" data-json='<?php echo $dataJSON; ?>' class="rdbottom8 wholebottom darkred">
                        <?php echo $confirmationText; ?>
                    </hellofresh>

                </div>

            </div>

        </form>

    </popup-module>


<?php

} else {
    exit('0');
}

?>