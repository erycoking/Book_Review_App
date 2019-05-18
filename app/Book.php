<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Book table
 */
class Book extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'description'];

    /**
     * defing a relationship with the users table
     *
     * a book belongs to a single user
     * Many to One Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * defing a relationship with the ratings table
     *
     * a book belongs may have many ratings/reviews
     * One to Many Relation
     */
    public function ratings()
    {
      return $this->hasMany(Rating::class);
    }
}
