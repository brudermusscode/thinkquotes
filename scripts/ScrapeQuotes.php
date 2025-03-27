<?php

namespace Bruder\Script;

ini_set("max_execution_time", 900000000);

require_once dirname(__DIR__) . "/vendor/autoload.php";

use Bruder\Database\Database;
use Symfony\Component\DomCrawler\Crawler;
use Bruder\Model\Author;
use GuzzleHttp\Client;
use Bruder\Eloquent\Justin;
use Bruder\Model\Topic;
use Random\Randomizer;

new Database("CLI");

class ScrapeQuotes extends Justin
{

  public function execute()
  {

    /**
     * @var string
     */
    $url = "https://zitatezumnachdenken.com";

    echo "Started scraping quotes from $url...\n";

    /**
     * @var array
     */
    $user_agents = [
      "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
      "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36",
      "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
      "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/91.0.864.41 Safari/537.36",
      "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299",
      "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
      "Mozilla/5.0 (Windows NT 6.3; Trident/7.0; ASL 1.0; BTRS1234567890) like Gecko",
      "Mozilla/5.0 (Linux; Android 10; Pixel 3 XL) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Mobile Safari/537.36",
      "Mozilla/5.0 (iPhone; CPU iPhone OS 13_3 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Version/13.0 Mobile/15E148 Safari/537.36",
      "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0",
      "Mozilla/5.0 (Windows NT 6.1; Trident/7.0; ASL 1.0; BTRS1234567890) like Gecko",
      "Mozilla/5.0 (Windows NT 6.1; Trident/7.0; ASL 1.0; BTRS1234567890) like Gecko",
      "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299",
      "Mozilla/5.0 (Windows NT 6.1; Trident/7.0; ASL 1.0; BTRS1234567890) like Gecko",
      "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
      "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0",
      "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:91.0) Gecko/20100101 Firefox/91.0",
      "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:92.0) Gecko/20100101 Firefox/92.0",
      "Mozilla/5.0 (Windows NT 6.1; Trident/7.0; ASL 1.0; BTRS1234567890) like Gecko",
      "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36"
    ];

    /**
     * @var int
     */
    $pages = 940;

    /**
     * @var int
     */
    $start_at_page = 936;

    /**
     * 1 second = 1,000,000 microseconds
     * @var int
     */
    $sleep_microseconds = 100000;


    /**
     * Iterate through every page and scrape the quotes!
     */
    for ($page = $start_at_page; $page <= $pages; $page++) {

      echo "♯ Page $page\n";

      /**
       * @var int
       */
      $count = 0;

      /**
       * @var string
       */
      $random_user_agent = array_rand($user_agents);

      /**
       * @var int
       */
      $retries = 3;
      $sleeptime = 1000000;

      for ($attempt = 0; $attempt < $retries; $attempt++) {
        try {

          /**
           * @var ResponseInterface
           */
          $client = (new Client)->request("GET", $url . "/?page=" . $page, [
            'headers' => [
              'User-Agent' => $random_user_agent,
            ]
          ]);

          /**
           * Break out of the loop.
           */
          break;
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
          if ($attempt < $retries - 1) {

            echo "Reconnecting...\n";

            usleep($sleeptime);
            $sleeptime *= 2;
          } else {
            throw $e;
          }
        }
      }

      /**
       * @var Crawler
       */
      $web = new Crawler(
        $client
          ->getBody()
          ->getContents()
      );

      /**
       * Filter by all quotes using the quote class.
       */
      $quotes = $web->filter("div#quotes > div.quote:not(.adArticle)");

      /**
       * Increase count.
       */
      $count += count($quotes);

      /**
       * Iterate through all quotes and extract the author +
       * quote-text. Checks, if the author already exists and if
       * not, creates a new one.
       */
      $quotes->each(function (Crawler $node) use ($sleep_microseconds, $random_user_agent) {

        /**
         * Sleep a little, for relaxing the SSL.
         */
        usleep($sleep_microseconds);

        $quote_href =
          $node
          ->filter("a.quote-text")
          ->attr("href");

        /**
         * Create a new Client for the quote to extract all the
         * necessary information.
         */
        /**
         * @var int
         */
        $retries = 3;
        $sleeptime = 1000000;

        for ($attempt = 0; $attempt < $retries; $attempt++) {
          try {

            /**
             * @var ResponseInterface
             */
            $Client = (new Client)->request("GET", $quote_href, [
              'headers' => [
                "User-Agent" => $random_user_agent,
              ]
            ]);

            /**
             * Break out of the loop.
             */
            break;
          } catch (\GuzzleHttp\Exception\ConnectException $e) {
            if ($attempt < $retries - 1) {

              echo "Reconnecting...\n";

              usleep($sleeptime);
              $sleeptime *= 2;  // Exponential backoff
            } else {
              throw $e;  // Rethrow if max retries are reached
            }
          }
        }

        $Node = new Crawler(
          $Client
            ->getBody()
            ->getContents()
        );

        /**
         * ? Extract the author.
         * @var Crawler
         */
        $NodeQuote = new Crawler($Node->html());

        $author_name = $NodeQuote->filter(".author > a")
          ->text();
        $author_name = filter_var($author_name, FILTER_SANITIZE_SPECIAL_CHARS);

        /**
         * @var ?Author
         */
        $Author = Author::where("name", $author_name)
          ->first();

        /**
         * Create a new author if none exist.
         */
        if (!$Author) {
          echo "Adding author »$author_name" . "«...";

          $Author = Author::create([
            "name" => $author_name,
          ]);
          $Author = $Author->fresh();

          echo " ✔\n";
        }

        /**
         * ? Extract the quote text.
         * @var Crawler
         */
        $NodeQuote = new Crawler($Node->html());

        $quote_text = $NodeQuote->filter("#single-page > p")
          ->text();
        $quote_text = filter_var($quote_text, FILTER_SANITIZE_SPECIAL_CHARS);

        /**
         * @var ?Quote
         */
        $Quote = $Author
          ->quotes()
          ->where("text", $quote_text)
          ->first();

        /**
         * Continue, if the quote already exists.
         */
        if ($Quote) {
          echo "Skipping quote ✔\n";
          return;
        }

        echo "Adding new quote...";

        /**
         * @var Quote
         */
        $Quote = $Author
          ->quotes()
          ->create([
            "text" => $quote_text,
          ]);
        $Quote = $Quote->fresh();

        echo " ✔\n";

        /**
         * ? Extract the topics.
         * @var Crawler
         */
        $NodeTopics = new Crawler($Node->html());

        /**
         * Filter topics by their a-tag which contain the topic name.
         */
        $topics = $NodeTopics->filter("div.view-tags")
          ->children("a");

        /**
         * Add topics only if any are set.
         */
        if ($topics->getNode(0)) {

          /**
           * Iterate through all topic nodes and create a new one
           * + create the corresponding polymorphic relationship
           *   in quote_topics for the quote.
           */
          $topics->each(function (Crawler $_node) use ($Quote) {
            /**
             * @var string
             */
            $topic_name = $_node->text();
            $topic_name = filter_var($topic_name, FILTER_SANITIZE_SPECIAL_CHARS);

            /**
             * @var ?Topic
             */
            $Topic = Topic::where("name", $_node->text())
              ->first();

            /**
             * Create a new topic, if it doesn't exist.
             */
            if (!$Topic) {
              echo "Adding topic »$topic_name" . "«...";

              $Topic = Topic::create([
                "name" => $topic_name,
              ]);
              $Topic = $Topic->fresh();

              echo " ✔\n";
            }

            /**
             * Create a polymorphic relation between the topic and
             * the quote.
             */
            $Quote->topics()
              ->attach($Topic);
          });
        }
      });

      echo "\n";
    }

    echo "Scraped $count quotes!";
  }
}
