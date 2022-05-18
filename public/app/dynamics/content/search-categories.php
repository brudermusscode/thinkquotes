<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

if (empty($_REQUEST["search"]) || !LOGGED) exit(NULL);

// transform author name
$search = htmlspecialchars($_REQUEST["search"]);
$search = '%' . $search . '%';

// preset queries on different cases
if (empty(preg_replace("/[\s]/i", "", $search))) {

    $query = "ORDER BY RAND() LIMIT 12";
} else {

    $query = "WHERE category_name LIKE ? ORDER by category_name LIMIT 12";
}

// get all authors
$stmt = $pdo->prepare("SELECT * FROM quotes_categories $query");
$stmt->execute([$search]);

if ($stmt->rowCount() > 0) {

    // fetch all rows and get all categories
    foreach ($stmt->fetchAll() as $s) {

?>

        <card class="fade-in">
            <p><?php echo $s->category_name; ?></p>
        </card>

    <?php

    }
} else {

    ?>

    <p style="font-size:1.2em;color:var(--colour-light);flex-grow:0;flex-shrink:0;flex-basis:100%;" class="tac w100 mt12">
        No categories found, if you proceed you gonna add it
    </p>

<?php

}
