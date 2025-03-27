<?php

namespace Bruder\Controller;

use Bruder\Eloquent\Controller;
use Bruder\Model\Quote;
use Bruder\Model\Vote;

class VotesController extends Controller
{
  /**
   * CREATE
   *
   * @param $params An array of params to create the instance with
   * @return null
   */
  public function create(array $params)
  {
    $escaped_params = $this->serialize_request_params(["reference_id", "reference_type", "vote_type"], $params);

    /**
     * User logged?
     */
    if (!$this->current_user)
      return $this->error($this->INVALID_REQUEST);

    /**
     * Params valid?
     */
    if (!$escaped_params)
      return $this->error($this->dd->INVALID_REQUEST);

    /**
     * @var ?Quote
     */
    $Quote = Quote::find($escaped_params->reference_id);

    /**
     * Quote exists?
     */
    if (!$Quote)
      return $this->error("<strong>Du kannst dich nicht selber finden, indem du in die Vergangenheit gehst. Du findest dich selber, indem du in die Gegenwart kommst</strong> - Eckhart Tolle");

    /**
     * @var ?Vote
     */
    $Vote = $this->current_user
      ->votes
      ->where("reference_type", "quote")
      ->where("reference_id", $Quote->id)
      ->first();

    /**
     * Vote already exists with this type?
     */
    if ($Vote)
      return $this->error("<strong>Du hast schon gevoted!</strong>");

    /**
     * Append all.
     */
    $escaped_params->current_user = $this->current_user;
    $escaped_params->reference = $Quote;

    return (new Vote)->new($escaped_params);
  }

  /**
   * UPDATE
   *
   * @return object Default return object.
   */
  public function edit(array $params)
  {
    $escaped_params = $this->serialize_request_params(["id"], $params);

    /**
     * User logged?
     */
    if (!$this->current_user)
      return $this->error($this->INVALID_REQUEST);

    /**
     * Params valid?
     */
    if (!$escaped_params)
      return $this->error($this->dd->INVALID_REQUEST);

    /**
     * @var ?Vote
     */
    $Vote = $this->current_user
      ->votes
      ->find($escaped_params->id);

    /**
     * Vote exists?
     */
    if (!$Vote)
      return $this->error($this->dd->INVALID_REQUEST);

    return $Vote->edit();
  }

  /**
   * DELETE
   *
   * @return object Default return object.
   */
  public function remove(array $params)
  {
    $escaped_params = $this->serialize_request_params(["id"], $params);

    /**
     * User logged?
     */
    if (!$this->current_user)
      return $this->error($this->INVALID_REQUEST);

    /**
     * Params valid?
     */
    if (!$escaped_params)
      return $this->error($this->dd->INVALID_REQUEST);

    /**
     * @var ?Vote
     */
    $Vote = $this->current_user
      ->votes
      ->find($escaped_params->id);

    /**
     * Vote exists?
     */
    if (!$Vote)
      return $this->error($this->dd->INVALID_REQUEST);

    return $Vote->remove();
  }

  /**
   * Serialize GET or POST parameters
   *
   * @return object
   */
  private function sanitize_request(array $params)
  {
    return $this->serialize_request_params([], $params);
  }
}
