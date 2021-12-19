<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

?>

<form data-form="quotes:add,quote" method="POST" action>
    <div class="inr">

        <label for="popup-module" class="mb32">
            <div class="label-inr light">
                <p><strong style="display:inline;">%author%</strong> said</p>
            </div>
        </label>

        <div class="input">
            <div class="pulse"></div>

            <textarea name="quote" placeholder="Love the whole world, as a mother loves her only child..." autofocus="true"></textarea>
        </div>

    </div>
</form>

<script class="dno">
    $(() => {

        // focus textarea on load
        $(document).find("textarea[name='quote']").focus();

    });
</script>