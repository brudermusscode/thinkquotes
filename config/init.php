<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

/**
 * Base error handling.
 */
require_once __DIR__ . "/init/error_handling.php";

use Bruder\Application\Cookie;

/**
 * Initialize database connection.
 */
new Bruder\Database\Database;

/**
 * Include files from config/init/ directory
 */
foreach (glob(__DIR__ . "/init/*.php") as $filename) {
  if (str_contains($filename, "error_handling"))
    continue;

  include_once $filename;
}

/**
 * Include definitions.
 */
require_once __DIR__ . "/define.php";

/**
 * Maintenance is enabled?
 */
if (IS_MAINTENANCE)
  header("location: /maintenance");

/**
 * If we came here, congratulations!
 * The application is officially initialized
 */
$app_initialized = true;
define('APP_INIT', $app_initialized);
