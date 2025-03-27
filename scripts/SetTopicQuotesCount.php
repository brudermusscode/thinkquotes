<?php

namespace Bruder\Script;

ini_set("max_execution_time", 900000000);

require_once dirname(__DIR__) . "/vendor/autoload.php";

use Bruder\Database\Database;
use Bruder\Eloquent\Justin;
use Bruder\Model\Topic;

new Database("CLI");

class SetTopicQuotesCount extends Justin
{

  public function execute()
  {

    echo "Started updating...\n";

    /**
     * Loop through all topics and update the count.
     */
    foreach (Topic::all() as $Topic) {
      /**
       * @var int
       */
      $quotes_count = $Topic->quotes()
        ->count();

      $Topic->update([
        "quotes_count" => $quotes_count,
      ]);
    }

    echo "Updated all topics!\n";
  }
}
