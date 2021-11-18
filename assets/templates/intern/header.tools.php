<?php

if (isset($pageTitle)) {

?>

    <div class="intern-head-tools mb42 posrel">
        <div class="lt">
            <hellofresh data-action="dropdown:open" class="hellofresh dark red circled big shadowed icon-only" onclick="window.history.back();">
                <div class="c-ripple js-ripple">
                    <span class="c-ripple__circle"></span>
                </div>

                <p class="lt posabs alignmiddle"><span class="material-icons-round md-24">arrow_back</span></p>

                <div class="cl"></div>
            </hellofresh>
        </div>

        <div class="right slideUp">
            <p class="tac title trimt"><?php echo $pageTitle; ?></p>
        </div>

        <div class="cl"></div>
    </div>


<?php

} else {
    header("location: ./404");
}
?>