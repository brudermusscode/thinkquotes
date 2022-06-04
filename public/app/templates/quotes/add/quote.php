<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_POST["quote_id"]) || !LOGGED) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

// variablize
(int) $quote_id = $_POST["quote_id"];

# get quote author
$q =
    "SELECT q.id, q.aid, qa.author_name
    FROM quotes q
    JOIN quotes_authors qa ON q.aid = qa.id
    WHERE q.id = ? AND q.uid = ? AND q.is_draft = true
    LIMIT 1";
$get_author = $THQ->select($pdo, $q, [$quote_id, $my->uid], false);

if (!$get_author->status) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

if (!$get_author->stmt->rowCount() > 0) {
    include_once TEMPLATES . "/quotes/add/_error.php";
    exit();
}

# fetch the author name
$author_name = $get_author->fetch->author_name;

?>

<form data-form="quotes:add,quote" method="POST" action>
    <div class="inr">

        <label for="popup-module" class="mb32">
            <div class="label-inr light">
                <p><strong style="display:inline;"><?php echo $author_name; ?></strong> said</p>
            </div>
        </label>

        <div class="input">
            <div class="pulse"></div>
            <textarea name="quote_text" placeholder="Love the whole world, as a mother loves her only child..." autofocus="true"></textarea>
        </div>

    </div>
</form>

<script class="dno">
    $(() => {

        // focus textarea on load
        $(document).find("textarea[name='quote']").focus();
    });
</script>