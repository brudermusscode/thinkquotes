<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (empty($_REQUEST["author"]) || !LOGGED) {

    // variablize
    $author = htmlspecialchars($_REQUEST["author"]);

    // start mysql transaction
    $pdo->beginTransaction();

    // insert the author
    $stmt = $pdo->prepare("INSERT INTO quotes_authors (uid, author_name) VALUES (?, ?)");
    $stmt = $THQ->execute($stmt, [$my->uid, $author], $pdo, false);

    if ($stmt->status) {

        // store the new id in aid variable
        $aid = $stmt->lastInsertId;

        // check for permissions of user to add new things
        // before actually committing
        if ($my->post_permissions !== "full") {

            $return->message = "Please choose from preset authors. Your permissions aren't set to add new ones";
            exit(json_encode($return));
        }

        // commit mysql transaction
        $pdo->commit();
    } else {

        // switch to return error codes of thrown exception
        switch ($stmt->code) {

                // ducplicate key entry on author_name
                // keep the author name and continue the script
            case "23000":

                // select the author and get the id
                $stmt = $pdo->prepare("SELECT * FROM quotes_authors WHERE author_name = ? LIMIT 1");
                $stmt->execute([$author]);

                // check again if author exists
                if ($stmt->rowCount() < 1) {
                    exit(json_encode($return));
                }

                // fetch the select statement and store the id
                $aid = $stmt->fetch()->id;
                break;

            default:
                exit(json_encode($return));
        }
    }

    // TODO: add draft as soon as author was added

    // get the content for adding quotes
    // TODO: find better method to include the file
    $content = file_get_contents($url->main . "/assets/dynamics/steps/quotes/elements/quote.php");

    // replace %% with actual strings
    // in this case just the author
    $content = str_replace("%author%", $author, $content);

    // set the status for return to true
    $return->status = true;

    // store the author id in the return object
    $return->aid = $aid;

    // pass the content from the PHP file to the return message
    $return->message = $content;

    // exit the script with encoding the return array to JSON
    exit(json_encode($return));
} else {
    exit(json_encode($return));
}

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