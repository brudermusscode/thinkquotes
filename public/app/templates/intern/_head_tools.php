<?php if (!isset($pageTitle)) $pageTitle = 'N/A'; ?>

<div class="intern-head-tools mb42 posrel <?php if ($pageTitle == 'Updates') echo 'w98'; ?>">
    <div class="lt">
        <hellofresh data-action="dropdown:open" class="hellofresh dark red rounded shadowed icon-only" onclick="window.history.back();">
            <div class="c-ripple js-ripple">
                <span class="c-ripple__circle"></span>
            </div>

            <p class="tac"><i class="material-icons std">arrow_back</i></p>

            <div class="cl"></div>
        </hellofresh>
    </div>

    <div class="right slideUp">
        <p class="tac title trimt"><?php echo $pageTitle; ?></p>
    </div>

    <div class="cl"></div>
</div>