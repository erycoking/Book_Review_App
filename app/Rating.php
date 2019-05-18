<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * ratings table
 */
class Rating extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['book_id', 'user_id', 'rating', 'review'];

    /**
     * defing a relationship with the books table
     *
     * Many to One Relation
     */
    public function book()
    {
      return $this->belongsTo(Book::class);
    }
}
