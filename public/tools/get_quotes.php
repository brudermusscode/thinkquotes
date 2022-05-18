<?php

# require database connection
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/config/init.php';

define("UID", $my->uid);

# webcrawler
use Goutte\Client;

# new crawler client
$client = new Client();

// set timelimit to zero
set_time_limit(0);

// set a counter to show how many quotes have been inserted
$counter = 0;

# how many pages should be itered through?
$iterate_through_pages = 4;


if (isset($_REQUEST["getQuotes"])) {

    $it = 0;

    // how many iterations should be done
    for ($i = 1; $i <= $iterate_through_pages; $i++) {

        // get the website
        $crawler = $client->request('GET', 'https://www.zitatezumnachdenken.com?page=' . $i);

        $crawler->filter('.quote')->each(function ($node) {

            if ($node->children('.quote-text')->count()) {

                $c = new Client();

                $href = $node->children('.quote-text')->attr('href');
                $newCrawler = $c->request('GET', $href);

                $newCrawler->filter('.quote')->each(function ($n) {

                    $system = new Client();

                    $pdo = NULL;

                    try {
                        // set up dns string
                        $dsn = 'mysql:host=mysql;dbname=thinkquotes_dev';
                        $pdo = new PDO($dsn, 'root', 'secret');

                        // preset attributes
                        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (\PDOException $e) {
                        exit($e->getMessage());
                    }


                    $quote = htmlspecialchars($n->children('p')->first()->text());
                    $upvotes = (int) $n->children('.quote-meta > a > .like-text > .like-count')->first()->text();
                    $author = htmlspecialchars($n->children('.author')->text());
                    $categories = htmlspecialchars($n->children('.view-tags')->text());

                    // format categories to array
                    $categories = preg_replace("/Themen: /", "", $categories);
                    $categories = preg_replace("/, /", ",", $categories);
                    $categories = explode(",", $categories);

                    if (empty($categories)) (object) $categories = [];

                    // **** START INSERTING AUTHOR
                    $stmt = $pdo->prepare("INSERT INTO quotes_authors (uid, author_name) VALUES (?, ?)");
                    $stmt = $system->execute($stmt, [UID, $author], $pdo, false);

                    if ($stmt->status) {

                        $aid = $stmt->lastInsertId;
                    } else {

                        switch ($stmt->code) {

                                // duplicate key, category exists
                            case "23000":

                                // get author id
                                $stmt = $pdo->prepare("SELECT * FROM quotes_authors WHERE author_name = ? LIMIT 1");
                                $stmt->execute([$author]);

                                // store author id
                                $aid = $stmt->fetch()->id;

                                break;

                            default:

                                exit($stmt->message);
                                break;
                        }
                    }
                    // *** DONE INSERTING AUTHOR

                    // *** START INSERTING QUOTE
                    $stmt = $pdo->prepare("INSERT INTO quotes (uid, aid, sid, quote_text, upvotes, is_draft) VALUES (?, ?, '1', ?, ?, '0')");
                    $stmt = $system->execute($stmt, [UID, $aid, $quote, $upvotes], $pdo, false);

                    if ($stmt->status) {

                        // store the quote id and use in categories_used
                        $qid = $stmt->lastInsertId;

                        // *** START INSERTING CATEGORIES
                        $categoryCounter = count((array) $categories);
                        $iterations = 0;

                        foreach ((object) $categories as $c) {

                            $commit = false;
                            if ($iterations === $categoryCounter) {
                                $commit = true;
                            }

                            $stmt = $pdo->prepare("INSERT INTO quotes_categories (uid, category_name) VALUES (?, ?)");
                            $stmt = $system->execute($stmt, [UID, $c], $pdo, $commit);

                            if ($stmt->status) {

                                // store inserted category id
                                $cid = $stmt->lastInsertId;
                            } else {

                                switch ($stmt->code) {

                                        // duplicate key, category exists
                                    case "23000":

                                        // get author id
                                        $stmt = $pdo->prepare("SELECT id FROM quotes_categories WHERE category_name = ? LIMIT 1");
                                        $stmt->execute([$c]);

                                        // store category id
                                        $cid = $stmt->fetch()->id;
                                        break;

                                    default:

                                        exit($stmt->message);
                                        break;
                                }
                            }

                            // ** START INSERTING USED CATEGORIES
                            $stmt = $pdo->prepare("INSERT INTO quotes_categories_used (qid, cid) VALUES (?, ?)");
                            $stmt = $system->execute($stmt, [$qid, $cid], $pdo, false);

                            if (!$stmt->status) {
                                exit($stmt->message);
                            }

                            $iterations++;
                        }
                    } else {
                        exit($stmt->message);
                    }

                    $pdo = NULL;
                });
            }
        });

        $it++;
    }

    echo $it . " pages copied";
}

?>

<form action="#" method="POST">

    <button type="submit" name="getQuotes">Get Quotes!</button>

</form>