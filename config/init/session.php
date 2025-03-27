<?php

use Bruder\Application\Cookie;
use Bruder\Model\User;
use Bruder\Utils\Utils;

/**
 * Check if a unique cookie is set.
 */
$__SESSION_UNIQUE_IDENTIFIER = Cookie::get("__su_idc__");

/**
 * @var array
 */
$__SESSION_UNIQUE_ID_EXPLODE = $__SESSION_UNIQUE_IDENTIFIER !== null
  ? explode(",§,", $__SESSION_UNIQUE_IDENTIFIER)
  : [];

/**
 * @var ?User
 */
$__CURRENT_USER = count($__SESSION_UNIQUE_ID_EXPLODE) > 1
  ? User::with("votes")
  ->where("id", $__SESSION_UNIQUE_ID_EXPLODE[0])
  ->first()
  : null;

/**
 * Check, if the user exists based on the stored id and if the
 * stored token is the key for decrypting the hashed token stored
 * in the database of this user.
 */
$__USER_AUTHENTIC = $__CURRENT_USER
  ? User::decrypt_password($__SESSION_UNIQUE_ID_EXPLODE[1], $__CURRENT_USER->token)
  : null;

/**
 * Delete the user if the token is not the right key.
 */
if ($__CURRENT_USER && !$__USER_AUTHENTIC) {

  /**
   * Remove the user.
   */
  // $__CURRENT_USER->delete();

  /**
   * Delete the unique id cookie.
   */
  $__CURRENT_USER->invalidate_session();
}

/**
 * Create a new user based on the authenticity.
 */
if (!$__USER_AUTHENTIC) {

  /**
   * Enforce a unique id by checking repeatedly if the generated
   * token already exists in the database.
   */
  do {
    $__SESSION_TOKEN = Utils::create_unique_token(32);
  } while (
    User::where("token", $__SESSION_TOKEN)
    ->exists()
  );

  /**
   * Create the user!
   */
  $__CURRENT_USER = User::create([
    "token" => User::encrypt_password($__SESSION_TOKEN),
  ])
    ->fresh();

  define("COOKIE_SAMESITE_STRICT", "Strict");
  define("COOKIE_SAMESITE_LAX", "Lax");
  define("COOKIE_SAMESITE_NONE", "None");

  /**
   * Create identifier cookie with the generated token.
   */
  Cookie::set(
    "__su_idc__",
    $__CURRENT_USER->id . ",§," . $__SESSION_TOKEN,
    "+2 years",
    true,
    COOKIE_SAMESITE_STRICT,
  );
}

/**
 * @var User
 */
$current_user = $__CURRENT_USER;
