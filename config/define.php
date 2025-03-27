<?php

use Bruder\Application\Application;
use Bruder\Application\Settings;
use Bruder\Application\Cookie;
use Bruder\Utils\Utils;

define("ENV", Application::get_environment_variables());
define('DEV', ENV->ENVIRONMENT == "dev");
define('STAGE', ENV->ENVIRONMENT == "stage");
define('PROD', ENV->ENVIRONMENT == "prod");

/**
 * Define Application constants to use around the website.
 */
define("CURRENT_TIMESTAMP",  date("Y-m-d H:i:s", time()));
define("APP_SETTING", (object) Settings::first()->getAttributes());
define('APP', new Application);
define("ROOT", Application::root());
define("PREROOT", dirname(ROOT));
define("VENDOR", ROOT . '/vendor');
define("CONFIG", ROOT . '/config');
define("ROUTE", ROOT . '/config/routes');
define("MODEL", ROOT . '/app/models');
define("BUILD", ROOT . '/app/build');
define("FUNCTION", ROOT . '/app/functions');
define("DATA", ROOT . '/app/data');
define("LOG", ENV->LOG_PATH);
define("JSON_RESPONSE", 'Content-type: application/json');
define("NOT_FOUND", 'location: /404');
define(false, 0);
define(true, 1);

/**
 * Template directory/UI components
 */
define("TEMPLATE", ROOT . '/app/templates');
define("HELPER", TEMPLATE . '/helpers');

/**
 * Base definitions
 */
define('APP_VERSION', APP_SETTING->version);
define('MAINTENANCE', APP_SETTING->is_maintenance);
define("APP_NAME", APP_SETTING->name);
define("HOME_URL", ENV->SERVER_SCHEME . "://" . ENV->DOMAIN . (ENV->SERVER_PORT != 443 ? ":" . ENV->SERVER_PORT : ""));
define("MAINTENANCE_URL", HOME_URL . ENV->MAINTENANCE_PATH);
define("IMAGE", ENV->ASSETS_URL . "/images");
define("VIDEO", ENV->ASSETS_URL . "/videos");
define("SCRIPT", ENV->ASSETS_URL . "/javascript");
define("STYLE", ENV->ASSETS_URL . "/stylesheets");
define("SOUND", ENV->ASSETS_URL . "/sounds");
define("ICON", ENV->ASSETS_URL . "/icons");

/**
 * PATHS
 */
define("ASSETS", ROOT . "/public/assets");

/**
 * Privacy measaures
 */
define('COOKIE_CONSENT', !empty($_COOKIE['COOKIE_CONSENT']) && $_COOKIE['COOKIE_CONSENT'] == 'true' ? true : false);

/**
 * If ever used, we need to conform with GDPR standarts and hide
 * certain things from non logged users.
 */
// define("GDPR", ?);

define("LOGGED", $__CURRENT_USER->exists());

/**
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, Settings ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
 */

define("PUREMODE_ENABLED", Cookie::get("PUREMODE") ? 1 : 0);
define("DARKMODE_ENABLED", Cookie::get("DARKMODE") ? 1 : 0);

/**
 * Bypass maintenance
 *
 * Get the bypass maintenance token and check if a cookie with the
 * value of it is present in the current user's client.
 */
$token = Utils::get_token("maintenance");

define(
  "BYPASS_MAINTENANCE",
  isset($_COOKIE['MAINTENANCE_TOKEN'])
    && $_COOKIE['MAINTENANCE_TOKEN'] == $token
    ? 1 : 0
);

unset($token);

/**
 * Maintenance
 */
define(
  "IS_MAINTENANCE",
  APP_SETTING->is_maintenance
    && $current_user->id !== 3
    && !defined("MAINTENANCE_ENABLED")
    && !BYPASS_MAINTENANCE
);
