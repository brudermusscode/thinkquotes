<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (
    isset($_REQUEST["author"]) &&
    !empty($_REQUEST["author"]) &&
    LOGGED
) {
    if ($my->post_permissions != "none") {

        $author = htmlspecialchars($_REQUEST["author"]);

?>

        <form data-form="quotes:add,quote" method="POST" action>
            <div class="inr">

                <label for="popup-module" class="mb32">
                    <div class="label-inr light">
                        <p><strong style="display:inline;"><?php echo $author; ?></strong> said</p>
                    </div>
                </label>

                <div class="input">
                    <div class="pulse"></div>

                    <input name="author" type="hidden" value="<?php echo $author; ?>" />

                    <textarea name="quote" placeholder="Love the whole world, as a mother loves her only child..." autofocus="true"></textarea>
                </div>

            </div>
        </form>

        <script class="dno">
            $(() => {

                $(document).find("textarea[name='quote']").focus();

            });
        </script>

<?php

    } else {
        exit(1);
    }
} else {
    exit(0);
}

?>