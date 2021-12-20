<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

?>

<popup-module>
    <form data-form="quotes:add,author" method="POST" action>
        <div class="inr">

            <label for="popup-module" class="mb32">
                <div class="label-inr light">
                    <p>Who's the <strong style="display:inline;">originator</strong>?</p>
                </div>
            </label>

            <div class="input">
                <div class="pulse"></div>
                <input name="author" type="text" placeholder="Buddha, Mark Aurel, Arthur Schopenhauer, ..." autofocus="true" />
            </div>

            <div class="recommendations" data-element="quotes:add,recommended">

                <?php

                $stmt = $pdo->prepare("SELECT * FROM quotes_authors ORDER BY RAND() LIMIT 12");
                $stmt->execute();

                foreach ($stmt->fetchAll() as $s) {

                ?>

                    <card>
                        <p><?php echo $s->author_name; ?></p>
                    </card>

                <?php } ?>

            </div>

            <div style="height:200px;visibility:hidden;opacity:0;"></div>

        </div>
    </form>
</popup-module>

<steps>
    <div class="steps-inr">

        <div class="description disfl fldirrow">
            <p class="mr12">
                <i class="ri-information-fill small"></i>
            </p>
            <p class="trimt" here>Choose the author, that created your following quote</p>

            <div class="cl"></div>
        </div>

        <div class="tools">
            <div class="disfl fldirrow">
                <div>
                    <hellofresh data-hellofresh="quotes:add,submit" class="hellofresh hover-shadow shadowed green rd12 icon-only mr12 posrel">
                        <div class="c-ripple js-ripple">
                            <span class="c-ripple__circle"></span>
                        </div>
                        <p class="lt posabs alignmiddle">
                            <i class="ri-arrow-right-line std"></i>
                        </p>

                        <div class="cl"></div>
                    </hellofresh>
                </div>
            </div>
        </div>

        <div class="cl"></div>
    </div>
</steps>