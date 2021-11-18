<?php

require_once "./../../../session/session.inc.php";


if (isset($_POST["what"], $_POST["value"]) && $isLoggedIn) {

    $what = $_POST["what"];
    $value = $_POST["value"];

    // valid inputs
    $validWhats = array(
        "quotes_authors",
        "quotes_sources",
        "quotes_categories"
    );

    // define column name
    switch ($what) {
        case "quotes_authors":
            $column = "author_name";
            break;
        case "quotes_sources":
            $column = "source_name";
            break;
        case "quotes_categories":
            $column = "category_name";
            break;
        default:
            exit('0');
    }

    // check array for valid input
    if (in_array($what, $validWhats)) {

        $likeValue = '%' . $value . '%';

        // get names from database
        $checkAuthorAdded = $pdo->prepare("SELECT $column FROM $what WHERE $column LIKE ? ORDER BY $column DESC LIMIT 4");
        $checkAuthorAdded->execute([$likeValue]);

        if ($checkAuthorAdded->rowCount() > 0) {

            foreach ($checkAuthorAdded->fetchAll() as $w) {

                if ($checkAuthorAdded->rowCount() == 1 && $w->$column === $value) {
                    exit('1');
                }
?>

                <div data-value="<?php echo ucfirst($w->$column); ?>">
                    <p><?php echo ucfirst($w->$column); ?></p>
                </div>


<?php

            }
        } else {
            exit('1');
        } // no results
    } else {
        exit('0');
    } // unknown error
} else {
    exit('0');
} // unknown error

?>