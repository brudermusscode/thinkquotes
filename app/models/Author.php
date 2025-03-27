<?php

namespace Bruder\Model;

use Bruder\Eloquent\Justin;
use Bruder\Model\Quote;

class Author extends Justin
{
  /**
   * @var string
   */
  protected $table = "authors";

  /**
   * @var array
   */
  protected $fillable = [
    "name",
    "note",
    "deleted_at",
    "updated_at",
  ];

  /**
   * @param $params
   * @return object
   */
  public function new(object $params)
  {
    return $this->success("Author has been created!");
  }

  /**
   * @return object
   */
  public function edit()
  {
    return $this->success("Author has been updated!");
  }

  /**
   * @return object
   */
  public function remove()
  {
    return $this->success("Author has been removed!");
  }

  /**
   * @return Quote
   */
  public function quotes()
  {
    return $this->hasMany(Quote::class);
  }

  /**
   * @return ?Topic
   */
  public function topics()
  {
    return $this->hasMany(Quote::class)
      ->join('quote_topics', 'quotes.id', '=', 'quote_topics.quote_id')
      ->join('topics', 'quote_topics.topic_id', '=', 'topics.id')
      ->select('topics.*')
      ->distinct();  // Avoid duplicates}
  }
}
