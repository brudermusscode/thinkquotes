<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST['quote_id'])) exit(NULL);

(int) $quote_id = $_POST['quote_id'];

# get quote
$q =
    "SELECT q.*
    FROM quotes q
    WHERE q.id = ? AND q.uid = ? AND q.is_draft = true
    LIMIT 1";
$get_quote = $THQ->select($pdo, $q, [$quote_id, $my->uid], false);

if (!$get_quote->status) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

if (!$get_quote->stmt->rowCount() > 0) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

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
            <input name="source_name" type="text" placeholder="TV, Book, Internet, Discord ..." autofocus="true" />
        </div>

        <div class="recommendations" data-element="quotes:add,recommended">

            <?php

            $stmt = $pdo->prepare("SELECT * FROM quotes_sources ORDER BY RAND() LIMIT 12");
            $stmt->execute();

            foreach ($stmt->fetchAll() as $s) { ?>

                <card>
                    <p><?php echo $s->source_name; ?></p>
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