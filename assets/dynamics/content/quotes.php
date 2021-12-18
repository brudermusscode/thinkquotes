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
                    ORDER BY $o 
                    DESC LIMIT ?
                ";
                $bind = [$l];
                break;
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
            }

            // querry all quotes
            foreach ($getQuotes->fetchAll() as $q) {

                // check if is favorite
                if (LOGGED) {
                    $getFaved = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ? AND deleted = '0'");
                    $getFaved->execute([$q->qid, UID]);

                    $isFavorite = FALSE;
                    if ($getFaved->rowCount() > 0) {
                        $isFavorite = TRUE;
                    }

                    $myQuote = false;
                    if ($q->uid === UID) {
                        $myQuote = true;
                    }
                }

                // get fave count
                $getAllFaves = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND deleted = '0'");
                $getAllFaves->execute([$q->qid]);

                // get categories
                $getCategories = $pdo->prepare("
                    SELECT * 
                    FROM quotes_categories_used, quotes_categories 
                    WHERE quotes_categories_used.cid = quotes_categories.id
                    AND quotes_categories_used.qid = ?
                    ORDER BY quotes_categories_used.id 
                    DESC LIMIT 3
                ");
                $getCategories->execute([$q->qid]);

            ?>




                <quote data-element="quote" data-quote-id="<?php echo $q->qid; ?>" data-json='[{"qid":"<?php echo $q->qid; ?>"}]' class="fade-in">

                    <div data-append="overlay" class="quote--outer mshd-1">

                        <style>
                            quote .quote--outer .q-inr .edit-overlay {
                                position: relative;
                            }

                            quote .quote--outer .q-inr .edit-overlay {
                                position: relative;
                            }

                            quote .quote--outer .q-inr .edit-overlay textarea {
                                resize: none;
                                width: 100%;
                                border-bottom: 1px solid rgba(0, 0, 0, .24);
                                transition: all .1s linear;
                                color: var(--colour-dark);
                                padding-bottom: 12px;
                            }

                            quote .quote--outer .q-inr .edit-overlay textarea:focus {
                                border-bottom: 1px solid var(--colour-red);
                            }
                        </style>

                        <?php if (LOGGED) { ?>

                            <div data-element="dropdown" class="posrel" travelhereboy data-react="function:quotes,edit,hide">
                                <div class="q-top-tools">

                                    <div class="sizing" data-action="dropdown:open">
                                        <p>
                                            <i class="ri-arrow-down-s-line std"></i>
                                        </p>
                                    </div>

                                    <dropdown data-dropdown="header,usermenu" data-react="dropdown:open" class="mshd-2">
                                        <div class="dd-inr">
                                            <ul>

                                                <?php if ($myQuote) { ?>

                                                    <li class="has-icon trimt" data-action="popup:quotes,edit">
                                                        <p>
                                                            <i class="ri-edit-circle-fill small"></i>
                                                        </p>
                                                        <p>Edit</p>
                                                    </li>

                                                    <li class="has-icon trimt" data-action="popup:quotes,delete">
                                                        <p>
                                                            <i class="ri-delete-bin-4-fill small"></i>
                                                        </p>
                                                        <p>Archive</p>
                                                    </li>

                                                <?php } else { ?>

                                                    <li class="has-icon trimt" data-action="popup:quotes,report">
                                                        <p>
                                                            <i class="ri-flag-2-fill small"></i>
                                                        </p>
                                                        <p>Report</p>
                                                    </li>

                                                <?php } ?>

                                            </ul>
                                        </div>
                                    </dropdown>
                                </div>
                            </div>

                        <?php } ?>

                        <div class="q-inr">
                            <div data-react="function:quotes,edit,hide">

                                <div class="author fw7 mb4">
                                    <p><?php echo $q->author_name; ?></p>
                                </div>

                                <div class="q-text">
                                    <p><?php echo $q->quote_text; ?></p>
                                </div>

                                <div class="q-categories">

                                    <?php foreach ($getCategories->fetchAll() as $cat) { ?>

                                        <div class="category-banner lt mt4" data-quote-category-id="<?php echo $cat->id; ?>" data-json='[{"cid","<?php echo $cat->id; ?>"}]'>
                                            <?php echo ucfirst($cat->category_name); ?>
                                        </div>

                                    <?php } ?>

                                    <div class="cl"></div>

                                </div>

                            </div>
                        </div>

                        <?php if (LOGGED) { ?>

                            <div class="tools">
                                <div class="disfl fldirrow" style="padding:12px 32px;">

                                    <div style="margin-right:auto;" class="disfl fldirrow">
                                        <a href="/u/profile/<?php echo $q->uid; ?>">
                                            <div class="to-profile">
                                                <p><?php echo $q->username; ?></p>
                                            </div>
                                        </a>
                                    </div>

                                    <div style="margin-left:auto;" class="disfl flexdirrow">
                                        <div class="duo">
                                            <div data-action="function:quotes,favorite" class="lt uno love <?php if ($isFavorite) { ?>active<?php } ?>">
                                                <i class="ri-heart-3-fill small"></i>
                                            </div>
                                            <div class="lt duo-text">
                                                <p data-react="functions:quotes,favorite,count"><?php echo $getAllFaves->rowCount(); ?></p>
                                            </div>

                                            <div class="cl"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <?php } ?>

                    </div>

                    <div style="width:100%;height:1.4em;visibility:hidden;"></div>
                </quote>

            <?php } ?>

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