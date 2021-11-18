<?php

require_once "./../../../session/session.inc.php";


// 69: NO PERMISSIONS
// 88: NO SIDE PERMISSIONS (adding authors, sources, categories)
// 100: ALRIGHT YES MAN SUCCESS

$pdo->beginTransaction();

if (
    isset($_POST["qid"], $_POST["quote"], $_POST["author"], $_POST["source"], $_POST["categories"])
    && $isLoggedIn
) {

    $category = "";

    $getArrayLenght = count($_POST);

    if ($getArrayLenght == 5) {

        if (
            $_POST["qid"] !== ""
            && $_POST["quote"] !== ""
            && $_POST["author"] !== ""
            && $_POST["source"] !== ""
            && $_POST["categories"] !== ""
        ) {

            // vars
            $errorCount = 0;
            $myid = $_SESSION["id"];
            $qid  = $_POST["qid"];
            $quote = $_POST["quote"];
            $author = $_POST["author"];
            $source = $_POST["source"];

            // check quote existence
            $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ? AND uid = ? AND deleted != '1'");
            $getQuote->execute([$qid, $myid]);

            if ($getQuote->rowCount() > 0) {

                // fetch quote
                $q = $getQuote->fetch();
                $aid = $q->aid;
                $sid = $q->sid;

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
                $checkUsersPermissions->execute([$myid]);
                $usersPermissionsFetch = $checkUsersPermissions->fetch();
                $usersPermissions = $usersPermissionsFetch->post_permissions;

                // check author existence
                $getAuthor = $pdo->prepare("SELECT id FROM quotes_authors WHERE author_name = ?");
                $getAuthor->execute([$author]);

                if ($getAuthor->rowCount() < 1) {

                    // new author, is the user permitted to add new?
                    if ($usersPermissions !== "none") {

                        // yes! insert new author
                        $insertAuthor = $pdo->prepare("INSERT INTO quotes_authors (uid,author_name) VALUES (?,?)");
                        $insertAuthor->execute([$myid, $author]);
                        if ($insertAuthor) {

                            // set new author
                            $aid = $pdo->lastInsertId();
                        } else {
                            $errorCount++;
                        }
                    } else {
                        exit("88");
                    }
                } else {

                    // set new author
                    $a = $getAuthor->fetch();
                    $aid = $a->id;
                }

                // check source existence
                $getSource = $pdo->prepare("SELECT * FROM quotes_sources WHERE source_name = ?");
                $getSource->execute([$source]);

                if ($getSource->rowCount() < 1) {

                    // new source, is the user permitted to add new?
                    if ($usersPermissions !== "none") {
                        $insertSource = $pdo->prepare("INSERT INTO quotes_sources (uid,source_name) VALUES (?,?)");
                        $insertSource->execute([$myid, $source]);
                        if ($insertSource) {

                            // set new source
                            $sid = $pdo->lastInsertId();
                        } else {
                            $errorCount++;
                        }
                    } else {
                        exit("88");
                    }
                } else {

                    // set new author
                    $s = $getSource->fetch();
                    $sid = $s->id;
                }

                // check category existence
                $categoryArray = [];
                $addedCategoryCount = 0;


                // FIRST: if category doesn't exist, check for
                // permission to add new ones and insert
                foreach ($category as $c) {

                    // check if category exists
                    $checkCategoryAdded = $pdo->prepare("SELECT * FROM quotes_categories WHERE category_name = ?");
                    $checkCategoryAdded->execute([$c]);

                    // if not
                    if ($checkCategoryAdded->rowCount() < 1) {

                        // check if user can add new
                        if ($usersPermissions === "full") {

                            // yes, add new category
                            $addCategory = $pdo->prepare("INSERT INTO quotes_categories (uid, category_name) VALUES (?,?)");
                            $addCategory->execute([$myid, $c]);

                            if ($addCategory) {

                                // set category id for used categories
                                $cid = $pdo->lastInsertId();

                                // add to category array
                                $categoryArray[] = $cid;
                            } else {
                                $errorCount++;
                            }
                        } else {
                            exit('88'); // no side permissions kek
                        }

                        // ... otherwise, get the ID of existing categories
                    } else {

                        // get ID of existing category
                        $getCategoryID = $pdo->prepare("SELECT id FROM quotes_categories WHERE category_name = ?");
                        $getCategoryID->execute([$c]);
                        $categoryID = $getCategoryID->fetch();
                        $cid = $categoryID->id;

                        // add to category array
                        $categoryArray[] = $cid;
                    }
                }


                // SECOND: check for categories to be deleted in
                // used categories for this quote

                // create array with used categories
                $categoriesUsedArray = [];
                $createArrayCategoriesUsed = $pdo->prepare("SELECT id,cid FROM quotes_categories_used WHERE qid = ?");
                $createArrayCategoriesUsed->execute([$qid]);
                foreach ($createArrayCategoriesUsed->fetchAll() as $cuid) {
                    $cuid = $cuid->cid;
                    $categoriesUsedArray[] = $cuid;
                }

                // check if submitted categories are in that array
                foreach ($categoriesUsedArray as $cuid) {

                    // no! delete from categories used
                    if (!in_array($cuid, $categoryArray)) {
                        $deleteCategoryUsed = $pdo->prepare("DELETE FROM quotes_categories_used WHERE qid = ? AND cid = ?");
                        $deleteCategoryUsed->execute([$qid, $cuid]);
                        if (!$deleteCategoryUsed) {
                            $errorCount++;
                        }
                    }
                }


                // THIRD: check for existence in "category_used" on that quote
                foreach ($categoryArray as $cid) {

                    // ... the check
                    $getCategoryUsed = $pdo->prepare("SELECT cid FROM quotes_categories_used WHERE qid = ? AND cid = ?");
                    $getCategoryUsed->execute([$qid, $cid]);

                    // no!
                    if ($getCategoryUsed->rowCount() < 1) {

                        // insert new used category
                        $insertNewCategoryUsed = $pdo->prepare("INSERT INTO quotes_categories_used (qid,cid) VALUES (?,?)");
                        $insertNewCategoryUsed->execute([$qid, $cid]);

                        if (!$insertNewCategoryUsed) {
                            $errorCount++;
                        }
                    }
                }


                // ******************************************
                // --- omg we did it ~ update the quote ---
                // ******************************************
                $updateQuote = $pdo->prepare("UPDATE quotes SET uid = ?, aid = ?, sid = ?, quote_text = ? WHERE id = ?");
                $updateQuote->execute([$myid, $aid, $sid, $quote, $qid]);

                if ($updateQuote && $errorCount === 0) {

                    $pdo->commit();
                    exit("100"); // success

                } else {

                    $pdo->rollback();
                    exit('0');
                }
            } else {
                exit('0'); // unknown error
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
