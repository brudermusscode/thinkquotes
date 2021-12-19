<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

?>

<form data-form="quotes:add,category" method="POST" action>
    <div class="inr">

        <label for="popup-module" class="mb32">
            <div class="label-inr light">
                <p>Choose a <strong style="display:inline;">category</strong></p>
            </div>
        </label>

        <div class="input">
            <div class="pulse"></div>

            <input name="category" type="text" placeholder="Add new one or choose from beneath..." autofocus="true" tabindex="1" />

            <input name="author" type="hidden" value="%author%" />
            <textarea name="quote" class="dno" readonly>%quote%</textarea>
            <input name="source" type="hidden" value="%source%" />

        </div>

        <div class="recommendations" data-element="quotes:add,recommended">

            <?php

            $stmt = $pdo->prepare("SELECT * FROM quotes_categories ORDER BY RAND() LIMIT 12");
            $stmt->execute();

            foreach ($stmt->fetchAll() as $s) {

            ?>

                <card>
                    <p><?php echo $s->category_name; ?></p>
                </card>

            <?php } ?>

        </div>

    </div>
</form>

<script class="dno">
    $(() => {

        // focus input on load
        $(document).find("input[type='text']").focus();
    });
</script>