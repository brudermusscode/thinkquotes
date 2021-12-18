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

        <form data-form="quotes:add,done" method="POST" action>
            <div class="inr">

                <label for="popup-module" class="mb32">
                    <div class="label-inr light">
                        <p>What's the <strong style="display:inline;">source</strong>?</p>
                    </div>
                </label>

                <div class="input">
                    <div class="pulse"></div>

                    <input name="author" type="hidden" value="<?php echo $author; ?>" />
                    <textarea name="quote" class="dno" value="<?php echo $quote; ?>" readonly></textarea>

                    <input name="source" type="text" placeholder="Internet, Book, ..." autofocus="true" />
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

                    <?php } ?>

                </div>

            </div>
        </form>

        <script class="dno">
            $(() => {

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