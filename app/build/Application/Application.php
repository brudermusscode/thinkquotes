<?php

namespace Bruder\Application;

use Bruder\Application\Cookie;
use Exception;
use RuntimeException;

class Application
{
  /**
   * @var string
   */
  public $environment;

  /**
   * All the available environments we develop, test and deploy to.
   *
   * @var array
   */
  private static $environments = [
    "dev",
    "stage",
    "prod"
  ];

  /**
   * Holds default dialogues for UI responsiveness.
   *
   * @var object
   */
  protected static $default_dialogues;

  /**
   * Whether or not the dark mode for the current theme is enabled.
   *
   * @var boolean
   */
  public $dark_mode_enabled;

  /**
   * @var Settings object
   */
  public $settings;

  public function __construct()
  {
    $this->dark_mode_enabled = Cookie::exists("DARKMODE") && Cookie::get("DARKMODE") == 1 || !Cookie::exists("DARKMODE");
    $this->environment = self::get_environment();
  }

  /**
   * Setter for the dark mode. To enable or not to enable.
   *
   * @return boolean
   */
  public function set_dark_mode(bool $value)
  {
    return Cookie::set("DARKMODE", $value, "+2 years");
  }

  /**
   * Get the environment from the environment file.
   *
   * @throws Exception if the environment file is not found or contains an invalid environment.
   * @return string the environment value ('dev', 'stage', or 'prod').
   */
  public static function get_environment()
  {
    $env_variables = self::get_environment_variables();
    $environment = $env_variables->ENVIRONMENT;

    if (!in_array($environment, self::$environments))
      throw new Exception("❌ Invalid environment specified in the .env file. Please check the Application class in the build folder for more information.");

    return $environment;
  }

  /**
   * Fetches the content of the .env file and returns it as an object.
   *
   * This function reads the .env file in the root directory of the PHP project,
   * parses its content, and converts it into an associative array. It then converts
   * the array into an object for easier access to environment variables.
   *
   * @return object|null An object containing the environment variables as properties,
   *    or null if the .env file is not found or empty.
   */
  public static function get_environment_variables()
  {
    $env_file_path = self::root() . "/.env";

    /**
     * Environment variables file is missing?
     */
    if (!file_exists($env_file_path))
      throw new Exception("❌ Environment variables file not found. Create a file named '.env' in the project root directory and add variables according to what is needed for this specific project. Usually, there is a .env.example file somewhere to copy from.");

    return (object) parse_ini_file($env_file_path);
  }

  /**
   * @return object
   */
  public static function get_default_dialogues()
  {
    self::$default_dialogues = (object) [
      "TRY_OR_STAFF" =>
      "Bruder, was ist passiert?",

      "INVALID_REQUEST" =>
      "Invalid request",

      "FIELDS_MISSING" =>
      "Fields missing",
    ];

    return self::$default_dialogues;
  }

  /**
   * Retrieves the root directory of the PHP project.
   *
   * This function iterates through the parent directories of the current file
   * until it finds the root directory, which is determined by the presence of a
   * specific marker file (e.g., `.project-root`). It returns the absolute path
   * to the root directory.
   *
   * @return ?string The absolute path to the root directory of the PHP project.
   */
  public static function get_root_directory(string $markerFile = '.project-root')
  {
    $currentDir = __DIR__;

    while ($currentDir !== '/') {
      if (file_exists($currentDir . DIRECTORY_SEPARATOR . $markerFile))
        return $currentDir;

      $currentDir = dirname($currentDir);
    }

    throw new RuntimeException('❌ Root directory not found. Please make sure the marker file is set up correctly. ❌');
  }

  public static function root()
  {
    return self::get_root_directory();
  }

  /**
   * Builds the URI for the current environment.
   *
   * @return string The URI.
   */
  public static function get_host_URI()
  {
    return $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"];
  }
}
