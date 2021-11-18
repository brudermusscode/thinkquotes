<?php

if (isset($subpage) && $subpage === "profile") {

?>

    <label class="posrel mb24">
        <div class="inr">
            <div>
                <p class="ttup">
                    <?php if ($isLoggedIn && $user->uid === $my['id']) {
                        echo "Your quotes";
                    } else {
                        echo "My quotes";
                    } ?>
                </p>
                <p class="ttup mr18"><span class="material-icons-round md-24">expand_more</span></p>
            </div>
        </div>
    </label>

    <quotes-outer class="mb32" data-load="content:quotes" data-json='[{"page":"profiles","order":"upvotes","limit":"20","uid":"<?php echo $user->id; ?>"}]'>

        <div class="actual"></div>

        <?php include_once "../assets/dynamics/content/quotes-loading.php"; ?>

    </quotes-outer>

<?php

} else {

    header("location: ./404");
}

?>