<?php

# require database connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/init.php';

if (empty($_REQUEST["search"]) || !LOGGED) exit(NULL);

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

    <p style="font-size:1.2em;color:var(--colour-light);flex-grow:0;flex-shrink:0;flex-basis:100%;" class="tac w100 mt12">
        No sources found, if you proceed you gonna add it
    </p>

<?php

}
