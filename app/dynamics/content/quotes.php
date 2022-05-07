<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

if (isset($_POST["page"], $_POST["order"], $_POST["limit"], $_POST["uid"])) {

    if (
        $_POST["page"] != ""
        && $_POST["order"] != ""
        && $_POST["limit"] != ""
        && $_POST["uid"] != ""
        && filter_var($_POST["limit"], FILTER_VALIDATE_FLOAT)
    ) {


        // variabilize
        $p = $_POST["page"];
        $o = $_POST["order"];
        $l = round($_POST["limit"]);
        $uid = $_POST["uid"];

        // check user is me
        $itsMe = FALSE;

        // if user is logged in, set it's me to true
        if (LOGGED) {
            if ($uid === UID) {
                $itsMe = TRUE;
            }
        }

        // set valid orders
        $validOrders = [
            "upvotes",
            "id"
        ];

        // check for validity
        if (!in_array($o, $validOrders)) {
            exit('0');
        }

        // create queries
        // home page
        switch ($p) {

                // startup page
            case "index":
                $sql = "
                    SELECT *, 
                    quotes.id AS qid, 
                    users.id AS uid, 
                    quotes_authors.id AS aid,  
                    quotes_sources.id AS sid  
                    FROM quotes, users, quotes_authors, quotes_sources 
                    WHERE quotes.uid = users.id
                    AND quotes.aid = quotes_authors.id 
                    AND quotes.sid = quotes_sources.id 
                    AND quotes.deleted = '0' 
                    ORDER BY quotes.upvotes 
                    DESC LIMIT ?
                ";
                $bind = [$l];
                break;

                // standard view profiles
            case "profiles":
                $sql = "
                    SELECT *, 
                    quotes.id AS qid, 
                    users.id AS uid, 
                    quotes_authors.id AS aid,  
                    quotes_sources.id AS sid  
                    FROM quotes, users, quotes_authors, quotes_sources 
                    WHERE quotes.uid = users.id
                    AND quotes.aid = quotes_authors.id 
                    AND quotes.sid = quotes_sources.id 
                    AND quotes.uid = ?
                    AND quotes.deleted = '0' 
                    ORDER BY $o 
                    DESC
                    LIMIT ?
                ";
                $bind = [$uid, $l];
                break;

                // profiles favorites
            case "profiles:favorites":
                $sql = "
                    SELECT *, 
                    quotes_favorites.id AS fid, 
                    quotes.id AS qid, 
                    quotes_sources.id AS sid,
                    quotes_authors.id AS auid,
                    users.id AS uid,
                    users_settings.id AS usid
                    FROM quotes_favorites, quotes, quotes_sources, quotes_authors, users, users_settings
                    WHERE quotes_favorites.qid = quotes.id
                    AND quotes.sid = quotes_sources.id
                    AND quotes.aid = quotes_authors.id
                    AND quotes.uid = users.id
                    AND quotes.uid = users_settings.id
                    AND quotes_favorites.uid = ?
                    AND quotes_favorites.deleted = '0'
                    AND quotes.deleted = '0' 
                    ORDER BY $o
                    DESC
                    LIMIT ?
                ";
                $bind = [$uid, $l];
                break;


            case "profiles:archive":
                $sql = "
                    SELECT *, 
                    quotes.id AS qid, 
                    users.id AS uid, 
                    quotes_authors.id AS aid,  
                    quotes_sources.id AS sid  
                    FROM quotes, users, quotes_authors, quotes_sources 
                    WHERE quotes.uid = users.id
                    AND quotes.aid = quotes_authors.id 
                    AND quotes.sid = quotes_sources.id 
                    AND quotes.uid = ?
                    AND quotes.deleted = '1' 
                    ORDER BY $o 
                    DESC
                    LIMIT ?
                ";
                $bind = [$uid, $l];
                break;
            default:
        }

        // execute
        $getQuotes = $pdo->prepare($sql);
        $getQuotes->execute($bind);

?>

        <div data-element="quote:grid" class="inr grid">

            <?php

            // no quotes content
            if ($getQuotes->rowCount() < 1) {

                include_once "quotes-empty.php";
            } else {

                // querry all quotes
                foreach ($getQuotes->fetchAll() as $elementInclude) {

                    $pure = false;

                    // include quote card
                    include SROOT . "/assets/dynamics/elements/quote.php";
                }
            }

            ?>

            <div style="display:block;visibility:hidden;height:12em;width:100%;"></div>

        </div>



<?php

    } else {
        exit('0');
    }
} else {
    exit('0');
}

?>