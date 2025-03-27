<?php

namespace Bruder\Model;

use Bruder\Eloquent\Justin;
use Bruder\Model\Author;

class Quote extends Justin
{
  /**
   * @var string
   */
  protected $table = "quotes";

  /**
   * @var array
   */
  protected $fillable = [
    "author_id",
    "text",
    "loves",
    "hates",
    "deleted_at",
    "updated_at",
  ];

  /**
   * @param $params
   * @return object
   */
  public function new(object $params)
  {
    return $this->success("Quote has been created!");
  }

  /**
   * @return object
   */
  public function edit()
  {
    return $this->success("Quote has been updated!");
  }

  /**
   * @return object
   */
  public function remove()
  {
    return $this->success("Quote has been removed!");
  }

  /**
   * @return Author
   */
  public function author()
  {
    return $this->belongsTo(Author::class);
  }

  /**
   * @return Topic
   */
  public function topics()
  {
    return $this->belongsToMany(
      Topic::class,
      "quote_topics",
    );
  }

  /**
   * @return Vote
   */
  public function votes()
  {
    return $this->hasMany(Vote::class, "id", "reference_id");
  }

  /**
   * @return int
   */
  public function vote_count()
  {
    return $this->loves - $this->hates;
  }
}
