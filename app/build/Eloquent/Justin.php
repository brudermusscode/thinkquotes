<?php

namespace Bruder\Eloquent;

use Bruder\Http\Request;
use Bruder\Application\Application as App;
use Bruder\Application\Application;
use Bruder\Database\Redis;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Bruder\File\JSON;

class Justin extends EloquentModel
{
  /**
   * @var string
   */
  private static $oauth_credentials_file = "/config/security/oauth_credentials.json";

  /**
   * @var object
   */
  public $dd;

  /**
   * @var object
   */
  public $return;

  /**
   * @var string
   */
  protected $environment;

  public function __construct()
  {
    $this->dd = App::get_default_dialogues();
    $this->return = Request::hi_mom();
    $this->environment = App::get_environment();
  }

  /**
   * @return \Predis\Client
   */
  public function redis()
  {
    return Redis::connect();
  }

  /**
   * @return App::default_dialogues()
   */
  public function dd()
  {
    return App::get_default_dialogues();
  }

  /**
   * @return ?object
   */
  public function data()
  {
    return $this->exists ? (object) $this->getAttributes() : null;
  }

  /**
   * @return string
   */
  public function current_timestamp()
  {
    return date("Y-m-d H:i:s", time());
  }

  /**
   * @return string
   */
  public function p(...$to_print)
  {
    echo "<pre>";
    print_r($to_print);
    echo "</pre>";
  }

  /**
   * Path has to be appended with a trailing slash /.
   *
   * @param string $path
   * @return string
   */
  public function template(string $path)
  {
    return Application::root() . "/app/templates$path";
  }

  /**
   * @param string $message
   * @return object
   */
  public function error(?string $message = null)
  {
    return Request::append_error($this->return, $message ?? $this->dd->INVALID_REQUEST, true);
  }

  /**
   * @param ?string $message
   * @return object
   */
  public function success(?string $message = null)
  {
    return Request::modoru($this->return, $message);
  }

  /**
   * Fetches the credentials for OAuth from the JSON file in configs.
   *
   * @param string $oauth_app The app to fetch for.
   * @return object The credentials.
   */
  public static function get_oauth_credentials(string|null $oauth_app = null)
  {
    $path = App::get_root_directory() . self::$oauth_credentials_file;
    $credentials = $oauth_app ? JSON::read($path)->$oauth_app : JSON::read($path);

    return $credentials;
  }

  /** ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, */
  /** ,,,,,,,,,,,,,,,,,,, DATABASE INTERACTIONS ,,,,,,,,,,,,,,,,,,,, */
  /** ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, */

  /**
   * @return void
   * @throws \Throwable
   */
  public function db_transaction()
  {
    return $this->getConnection()
      ->beginTransaction();
  }

  /**
   * @return void
   * @throws \Throwable
   */
  public function db_commit()
  {
    return $this->getConnection()
      ->commit();
  }

  /**
   * @return void
   * @throws \Throwable
   */
  public function db_rollback()
  {
    return $this->getConnection()
      ->rollBack();
  }
}
