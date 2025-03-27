<?php

namespace Bruder\Model;

use Bruder\Eloquent\Justin;
use Bruder\Model\Quote;

class Topic extends Justin
{
  /**
   * @var string
   */
  protected $table = "topics";

  /**
   * @var array
   */
  protected $fillable = [
    "name",
    "quotes_count",
    "deleted_at",
    "updated_at",
  ];

  /**
   * @param $params
   * @return object
   */
  public function new(object $params)
  {
    return $this->success("Topic has been created!");
  }

  /**
   * @return object
   */
  public function edit()
  {
    return $this->success("Topic has been updated!");
  }

  /**
   * @return object
   */
  public function remove()
  {
    return $this->success("Topic has been removed!");
  }

  /**
   * @return Quote
   */
  public function quotes()
  {
    return $this->belongsToMany(
      Quote::class,
      "quote_topics",
    );
  }
}
