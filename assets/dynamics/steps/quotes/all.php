<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (
    isset(
        $_REQUEST["qid"],
        $_REQUEST["category"]
    ) &&
    !empty($_REQUEST["qid"]) &&
    !empty($_REQUEST["category"]) &&
    is_numeric($_REQUEST["qid"]) &&
    LOGGED
) {

    // TODO: validate request values
    $qid = htmlspecialchars($_REQUEST["qid"]);
    $category = htmlspecialchars($_REQUEST["category"]);

    // start mysql transaction
    $pdo->beginTransaction();

    // insert the author
    // TODO: make multiple categories adding possible
    $stmt = $pdo->prepare("INSERT INTO quotes_categories (uid, category_name) VALUES (?, ?)");
    $stmt = $system->execute($stmt, [UID, $category], $pdo, false);

    if ($stmt->status) {

        // store the new id in aid variable
        $cid = $stmt->lastInsertId;

        // check for permissions of user to add new things
        // before actually committing
        if ($my->post_permissions !== "full") {

            $return->message = "Please choose from preset categories. Your permissions aren't set to add new ones";
            exit(json_encode($return));
        }
    } else {

        // switch to return error codes of thrown exception
        switch ($stmt->code) {

                // ducplicate key entry on source_name
                // keep the source name and continue the script
            case "23000":

                // select the source and get the id
                $stmt = $pdo->prepare("SELECT * FROM quotes_categories WHERE category_name = ? LIMIT 1");
                $stmt->execute([$category]);

                // check again if source exists
                if ($stmt->rowCount() < 1) {
                    exit(json_encode($return));
                }

                // fetch the select statement and store the id
                $cid = $stmt->fetch()->id;
                break;

            default:
                exit(json_encode($return));
        }
    }

    // insert into categories used for relation between quote and category
    $stmt = $pdo->prepare("INSERT INTO quotes_categories_used (qid, cid) VALUES (?, ?)");
    $stmt = $system->execute($stmt, [$qid, $cid], $pdo, true);

    if ($stmt->status) {

        // get current quote and show on process
        $stmt = $pdo->prepare("
            SELECT *, 
            quotes.id AS qid, 
            users.id AS uid, 
            quotes_authors.id AS aid,  
            quotes_sources.id AS sid  
            FROM quotes, users, quotes_authors, quotes_sources 
            WHERE quotes.uid = users.id
            AND quotes.aid = quotes_authors.id 
            AND quotes.sid = quotes_sources.id 
            AND quotes.id = ?
            AND quotes.deleted = '0' 
            LIMIT 1
        ");
        $stmt->execute([$qid]);

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
                    <input name="qid" type="hidden" value="<?php echo $qid; ?>" />
                </div>

                <?php

                foreach ($stmt->fetchAll() as $elementInclude) {

                    include_once SROOT . "/assets/dynamics/elements/quote.php";
                }

                ?>

            </form>
        </div>

        <script class="dno">
            $(() => {

            });
        </script>

<?php

        exit();
    } else {
        exit(false);
    }
} else {
    exit(false);
}
