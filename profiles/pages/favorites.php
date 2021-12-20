<?php

if (isset($subpage) && $subpage == "favorites") {

?>

    <label for="quotes" class="posrel mb24">
        <div class="label-inr">
            <p class="ttup">

                <?php

                if (LOGGED && $user->uid == UID) {
                    echo "Quotes you love";
                } else {
                    echo "Favorite quotes";
                }

                ?>

            </p>
            <p class="ttup mr18">
                <i class="ri-arrow-down-s-line std"></i>
            </p>
        </div>
    </label>

    <create-grid class="mb32" data-load="content:quotes" data-json='[{"page":"profiles:favorites","order":"upvotes","limit":"20","uid":"<?php echo $user->id; ?>"}]'>

        <div class="actual"></div>

        <?php include_once SROOT . "/assets/dynamics/content/quotes-loading.php"; ?>

    </create-grid>

<?php

} else {

    header("location: ./404");
}

?>