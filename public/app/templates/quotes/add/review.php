<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (empty($_POST['quote_id'])) exit(NULL);

(int) $quote_id = $_POST['quote_id'];

# get quote
$q =
    "SELECT *, q.id qid, q.uid uid
    FROM quotes q
        JOIN users u on u.id = q.uid
        JOIN quotes_authors qa on qa.id = q.aid
        JOIN quotes_sources qs on qs.id = q.sid
    WHERE q.deleted = false
    AND q.is_draft = true
    AND q.id = ?
    AND q.uid = ?
    ORDER BY q.upvotes
    DESC LIMIT 1";
$get_quote = $THQ->select($pdo, $q, [$quote_id, $my->uid], true);

if (!$get_quote->status) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

if (!$get_quote->stmt->rowCount() > 0) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

?>

<div class="inr">
    <form data-form="quotes:add,all" method="POST" action>

        <label for="popup-module" class="mb32">
            <div class="label-inr light">
                <p>Almost there!</p>
            </div>
        </label>

        <div class="input">
            <div class="pulse"></div>

            <?php

            $pure = true;

            foreach ($get_quote->fetch as $elementInclude) {

                include_once TEMPLATES . '/quotes/_quote.php';
            } ?>
        </div>

    </form>
</div>