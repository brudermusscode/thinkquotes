<?php

if (isset($subpage) && $subpage === "favorites") {

?>

    <label class="posrel mb24">
        <div class="inr">
            <p class="ttup">
                <?php

                if ($isLoggedIn && $user->uid === UID) {
                    echo "Quotes you love";
                } else {
                    echo "Favorite quotes";
                }

                ?>
            </p>
            <p class="ttup mr18"><span class="material-icons-round md-24">expand_more</span></p>
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