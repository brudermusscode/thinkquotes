<?php

namespace Bruder\Env;

use Bruder\Application\Application;

class Env
{
  /**
   * Get environment variables from the .env file.
   *
   * @param string $key
   * @return ?string
   */
  public static function get($key)
  {
    return Application::get_environment_variables()->$key ?? null;
  }
}
