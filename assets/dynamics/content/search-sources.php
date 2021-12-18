<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_REQUEST["search"]) && LOGGED) {

    // transform author name
    $source = htmlspecialchars($_REQUEST["search"]);
    $source = '%' . $source . '%';

    // preset queries on different cases
    if (empty(preg_replace("/[\s]/i", "", $source))) {

        $query = "ORDER BY RAND() LIMIT 12";
    } else {

        $query = "WHERE source_name LIKE ? ORDER by source_name LIMIT 12";
    }

    // get all authors
    $stmt = $pdo->prepare("SELECT * FROM quotes_sources $query");
    $stmt->execute([$source]);

    if ($stmt->rowCount() > 0) {

        // fetch all rows and get all sources
        foreach ($stmt->fetchAll() as $s) {

?>

            <card class="fade-in">
                <p><?php echo $s->source_name; ?></p>
            </card>

        <?php

        }
    } else {

        ?>

        No authors found, if you proceed you gonna add it

<?php

    }
} else {
    exit(0);
}
