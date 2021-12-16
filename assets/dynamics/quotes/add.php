<?php

// require mysql connection and session data
require_once $_SERVER["DOCUMENT_ROOT"] . "/session/session.inc.php";

// 69: NO PERMISSIONS
// 88: NO SIDE PERMISSIONS (adding authors, sources, categories)
// 100: ALRIGHT YES MAN SUCCESS

// start mysql transaction
$pdo->beginTransaction();

if (
    isset($_POST["quote"], $_POST["author"], $_POST["source"], $_POST["categories"])
    && $logged
) {

    $category = "";

    $getArrayLenght = count($_POST);

    if ($getArrayLenght == 4) {

        if (
            $_POST["quote"] !== ""
            && $_POST["author"] !== ""
            && $_POST["source"] !== ""
            && $_POST["categories"] !== ""
        ) {

            // vars
            $quote = $_POST["quote"];
            $author = $_POST["author"];
            $source = $_POST["source"];

            // transform categories
            $escapedCategories = $_POST["categories"];
            $replacedCategories = preg_replace("/[^a-zA-Z0-9öäüß,-]/", "", $escapedCategories);
            $category = str_getcsv($replacedCategories, ",", "'");
            $categoryArrayCount = count($category);


            // get users post permissions
            $checkUsersPermissions = $pdo->prepare("
                SELECT users_settings.post_permissions FROM users, users_settings
                WHERE users.id = users_settings.uid AND users.id = ?
            ");
            $checkUsersPermissions->execute([$my['id']]);
            $usersPermissionsFetch = $checkUsersPermissions->fetch();
            $usersPermissions = $usersPermissionsFetch->post_permissions;

            // ask for permissions at first
            if ($usersPermissions === "none") {
                exit('69');
            }


            // get quotes count posted
            $checkQuotesPosted = $pdo->prepare("SELECT * FROM quotes WHERE uid = ?");
            $checkQuotesPosted->execute([$my["id"]]);
            $quotes_posted = $checkQuotesPosted->rowCount();

            // *********************************
            // --- check author availability ---
            // *********************************
            $checkAuthorAdded = $pdo->prepare("SELECT * FROM quotes_authors WHERE author_name = ?");
            $checkAuthorAdded->execute([$author]);

            if ($checkAuthorAdded->rowCount() < 1) {
                $add_author = true;

                if ($usersPermissions === "full") {

                    $addAuthor = $pdo->prepare("INSERT INTO quotes_authors (uid, author_name) VALUES (?,?)");
                    $addAuthor->execute([$my["id"], $author]);
                    $aid = $pdo->lastInsertId();
                } else {
                    exit('88'); // no side permissions
                }
            } else {

                $add_author = false;

                $getAuthorID = $pdo->prepare("SELECT id FROM quotes_authors WHERE author_name = ?");
                $getAuthorID->execute([$author]);
                $authorID = $getAuthorID->fetch();

                $aid = $authorID->id;
                $addAuthor = true;
            }



            // *********************************
            // --- check source availability ---
            // *********************************
            $checkSourceAdded = $pdo->prepare("SELECT * FROM quotes_sources WHERE source_name = ?");
            $checkSourceAdded->execute([$source]);

            if ($checkSourceAdded->rowCount() < 1) {
                $add_source = true;

                if ($usersPermissions === "full") {

                    $addSource = $pdo->prepare("INSERT INTO quotes_sources (uid, source_name) VALUES (?,?)");
                    $addSource->execute([$my["id"], $source]);
                    $sid = $pdo->lastInsertId();
                } else {
                    exit('88'); // no side permissions
                }
            } else {

                $add_source = false;

                $getSourceID = $pdo->prepare("SELECT id FROM quotes_sources WHERE source_name = ?");
                $getSourceID->execute([$source]);
                $sourceID = $getSourceID->fetch();

                $sid = $sourceID->id;
                $addSource = true;
            }


            // *********************************
            // --- add the quote ---
            // *********************************
            $addQuote = $pdo->prepare("INSERT INTO quotes (uid, aid, sid, quote_text) VALUES (?,?,?,?)");
            $addQuote->execute([$my["id"], $aid, $sid, $quote]);
            $qid = $pdo->lastInsertId();


            // *********************************
            // --- loop through categories ---
            // *********************************

            $cidArray = array();
            $addedCategoryCount = 0;

            foreach ($category as $c) {

                $checkCategoryAdded = $pdo->prepare("SELECT * FROM quotes_categories WHERE category_name = ?");
                $checkCategoryAdded->execute([$c]);

                if ($checkCategoryAdded->rowCount() < 1) {

                    if ($usersPermissions === "full") {

                        $addCategory = $pdo->prepare("INSERT INTO quotes_categories (uid, category_name) VALUES (?,?)");
                        $addCategory->execute([$my["id"], $c]);
                        $cid = $pdo->lastInsertId();
                    } else {
                        exit('88');
                    }
                } else {

                    $getCategoryID = $pdo->prepare("SELECT id FROM quotes_categories WHERE category_name = ?");
                    $getCategoryID->execute([$c]);
                    $categoryID = $getCategoryID->fetch();
                    $cid = $categoryID->id;
                }

                $insertNewCategory = $pdo->prepare("INSERT INTO quotes_categories_used (timestamp, qid, cid) VALUES (?,?,?)");
                $insertNewCategory->execute([$main['fulldate'], $qid, $cid]);

                if ($insertNewCategory) {
                    $addedCategoryCount++;
                } else {
                    exit('0');
                }
            }

            if ($addQuote && $addAuthor && $addSource && $categoryArrayCount == $addedCategoryCount) {

                $newQuoteCount = $quotes_posted + 1;

                if ($newQuoteCount >= 3 && $usersPermissions !== "full") {

                    $updateUsersPermissions = $pdo->prepare("UPDATE users_settings SET post_permissions = 'none' WHERE uid = ?");
                    $updateUsersPermissions->execute([$_SESSION['id']]);

                    if ($updateUsersPermissions) {

                        $exitNum = "101";
                    } else {
                        exit('0');
                    }
                } else {

                    $exitNum = "100";
                }

                $pdo->commit();
                exit($exitNum); // success

            } else {

                $pdo->rollback();
                exit('0');
            }
        } else {
            exit('1');
        } // fill out all forms
    } else {
        exit('0');
    } // unknown error
} else {
    exit('0');
} // unknown error
