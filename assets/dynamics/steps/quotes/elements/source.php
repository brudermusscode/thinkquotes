<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

?>

<form data-form="quotes:add,source" method="POST" action>
    <div class="inr">

        <label for="popup-module" class="mb32">
            <div class="label-inr light">
                <p>What's the <strong style="display:inline;">source</strong>?</p>
            </div>
        </label>

        <div class="input">
            <div class="pulse"></div>

            <input name="author" type="hidden" value="%author%" />
            <textarea name="quote" class="dno" readonly>%quote%</textarea>

            <input name="source" type="text" placeholder="TV, Book, Internet, Discord ..." autofocus="true" />
        </div>

        <div class="recommendations" data-element="quotes:add,recommended">

            <?php

            $stmt = $pdo->prepare("SELECT * FROM quotes_sources ORDER BY RAND() LIMIT 12");
            $stmt->execute();

            foreach ($stmt->fetchAll() as $s) {

            ?>

                <card>
                    <p><?php echo $s->source_name; ?></p>
                </card>

            <?php

            }

            ?>

        </div>

    </div>
</form>

<script class="dno">
    $(() => {

        // focus input on load
        $(document).find("input[type='text']").focus();
    });
</script>