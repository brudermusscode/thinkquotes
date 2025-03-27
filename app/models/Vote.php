<?php

namespace Bruder\Model;

use Bruder\Eloquent\Justin;
use Bruder\Model\User;

class Vote extends Justin
{
  /**
   * @var string
   */
  protected $table = "votes";

  /**
   * @var array
   */
  protected $fillable = [
    "user_id",
    "reference_id",
    "reference_type",
    "vote_type",
    "deleted_at",
    "updated_at",
  ];

  /**
   * @param object $params
   * @return object
   */
  public function new(object $params)
  {
    /**
     * @var User
     */
    $CurrentUser = $params->current_user;

    /**
     * Just quotes by now.
     * @var Quote
     */
    $Reference = $params->reference;

    /**
     * @var Vote
     */
    $Vote = $CurrentUser->votes()
      ->create([
        "reference_id" => $Reference->id,
        "reference_type" => "quote",
        "vote_type" => $params->vote_type === 1 ? 1 : -1,
      ]);

    /**
     * @var string
     */
    $column_to_update = $params->vote_type == 1 ? "loves" : "hates";

    /**
     * Update the reference vote count.
     */
    $Reference->$column_to_update += 1;
    $Reference->save();

    /**
     * Append the vote id for the frontend.
     */
    $this->return->vote_id = $Vote->id;

    return $this->success("<strong>Vote has been created!</strong>");
  }

  /**
   * @param object $params
   * @return object
   */
  public function edit()
  {
    /**
     * @var int
     */
    $vote_type = $this->vote_type === 1 ? -1 : 1;

    /**
     * Update the vote.
     */
    $this->vote_type = $vote_type;
    $this->save();

    /**
     * @var string
     */
    $column_to_update = $vote_type === 1 ? "loves" : "hates";
    $other_column     = $vote_type === 1 ? "hates" : "loves";

    /**
     * Update the reference vote count.
     */
    $this->reference->$column_to_update = $this->reference->$column_to_update + 1;
    $this->reference->$other_column = $this->reference->$other_column - 1;
    $this->reference->save();

    return $this->success("Vote has been updated!");
  }

  /**
   * @return object
   */
  public function remove()
  {
    /**
     * @var string
     */
    $column_to_update = $this->vote_type === 1 ? "loves" : "hates";

    /**
     * Update the reference vote count.
     */
    $this->reference->$column_to_update = $this->reference->$column_to_update - 1;
    $this->reference->save();

    /**
     * Update the vote.
     */
    $this->delete();

    return $this->success("Vote has been removed!");
  }

  /**
   * @return User
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return Quote
   */
  public function reference()
  {
    return $this->belongsTo(
      match ($this->reference_type) {
        "quote" => Quote::class,
        default => null, // Will never happen.
      },
      "reference_id",
      "id",
    );
  }
}
