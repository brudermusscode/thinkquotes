<?php

namespace Bruder\Eloquent;

use Bruder\Http\Request;
use Bruder\Eloquent\Justin;
use Bruder\Model\User;
use Bruder\Utils\Arr;

class Controller extends Justin
{

  /**
   * Keys that are valid for prequests even tho not explicitly
   * noted down in the controller
   *
   * @var array
   */
  protected $valid_passthrough_keys = [
    "habibi",
    "csrf_token",
  ];

  public function __construct()
  {
    parent::__construct();

    $this->current_user = $this->get_current_user();
  }

  /**
   * @return ?User
   */
  public function get_current_user()
  {
    return (new User)->has_valid_session();
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
   * Checks for given array keys being present in another array
   * and for array keys that are not allowed to be passed.
   *
   * @param array $necessary The keys needing to be present
   * @param array $post_params The array to check against
   * @param array $optional Let keys pass that are there but not filled
   * @return object|false
   */
  protected function serialize_request_params(array $necessary, array $post_params, array $optional = [])
  {
    /**
     * @var array
     */
    $always_pass = [
      "csrf_token",
      "habibi",
    ];

    // Check if all required parameters are set in the post request
    foreach ($necessary as $param)
      if (!isset($post_params[$param]))
        return false;

    // Check if any parameter in the post request is not in the required or optional arrays
    foreach ($post_params as $key => $value)
      if (!in_array($key, $necessary) && !in_array($key, $optional) && !in_array($key, $always_pass))
        return false;

    /**
     * @var array
     */
    $serializedParams = [];

    /**
     * Sanitize all values recursively.
     */
    foreach ($post_params as $key => $value)
      if (is_array($value))
        $serializedParams[$key] = Arr::sanitize_special_chars($value);
      else
        $serializedParams[$key] = is_numeric($value) ? (int) $value : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);

    return (object) $serializedParams;
  }

  /**
   * Unset any key from an array except the given ones.
   *
   * @param string ...$keys The keys to retain in the array.
   * @param array[string] $array The original array.
   * @return ?object
   */
  function restrict_params(array $restrict, array $array): ?object
  {
    // TODO: Intelephense says no.
    foreach ($array as $key => $arr) {
      if (!array_key_exists($key, array_flip($restrict))) unset($array[$key]);
    }

    return $array ? (object) $array : null;
  }
}
