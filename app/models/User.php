<?php

namespace Bruder\Model;

use Bruder\Application\Cookie;
use Bruder\Eloquent\Justin;

class User extends Justin
{
  /**
   * @var string
   */
  protected $table = "users";

  /**
   * @var array
   */
  protected $fillable = [
    "token",
    "deleted_at",
    "updated_at",
  ];

  /**
   * @param $params
   * @return object
   */
  public function new(object $params)
  {
    return $this->success("User has been created!");
  }

  /**
   * @return object
   */
  public function edit()
  {
    return $this->success("User has been updated!");
  }

  /**
   * @return object
   */
  public function remove()
  {
    return $this->success("User has been removed!");
  }

  /**
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, VOTES ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   */


  /**
   * @return Vote
   */
  public function votes()
  {
    return $this->hasMany(Vote::class);
  }

  /**
   * @return ?Vote
   */
  public function has_voted_for(Quote $Quote)
  {
    $Votes = $this->votes
      ->where("reference_type", "quote")
      ->where("reference_id", $Quote->id)
      ->first();

    return $Votes;
  }

  /**
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,, VOTES ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   * ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
   */

  /**
   * Returns the valid user connected to the token set in the
   * unique identifier cookie. Fires of multiple and necessary
   * checks for validation.
   *
   * @return ?User
   */
  public function has_valid_session()
  {
    /**
     * @var ?string
     */
    $id_cookie = Cookie::get("__su_idc__");

    /**
     * Cookie id exists?
     */
    if (!$id_cookie)
      return $this->invalidate_session();

    $id_cookie_split = explode(",§,", $id_cookie);

    /**
     * Cookie id split consists of 2 parts?
     */
    if (count($id_cookie_split) < 2)
      return $this->invalidate_session();

    /**
     * @var ?User
     */
    $User = User::find($id_cookie_split[0]);

    /**
     * User exists?
     */
    if (!$User)
      return $this->invalidate_session();

    /**
     * @var bool
     */
    $password_valid = $this->decrypt_password($id_cookie_split[1], $User->token);

    /**
     * The user could manipulate the id in the unique id token and
     * put in another one. This would invalidate the own account
     * and in case of deleting users that are invalid, the user
     * could delete accounts from others. Might want to remember
     * this for the future.
     */
    // TODO: Give user the option for persisting accounts.
    if (!$password_valid)
      return $User->invalidate_session();

    return $User;
  }

  /**
   * @return null
   */
  public function invalidate_session()
  {
    /**
     * Delete unique identifier token.
     */
    Cookie::delete("__su_idc__");

    return null;
  }

  /**
   * Will hash the given password with md5 and afterwards using the
   * predefined PASSWORD_ARGON2ID algorhithm constant to encrypt the
   * password further.
   *
   * @param string $password
   * @return string
   */
  public static function encrypt_password(string $password)
  {
    /**
     * @var string
     */
    $password_md5_hash = md5($password);

    return password_hash($password_md5_hash, PASSWORD_ARGON2ID);
  }

  /**
   * @param string $password
   * @param string $hash
   * @return bool
   */
  public static function decrypt_password(string $password, string $hash)
  {
    return password_verify(
      md5($password),
      $hash
    );
  }
}
