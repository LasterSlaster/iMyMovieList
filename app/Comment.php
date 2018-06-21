<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment represents a model of the comment table
 *
 * @package App
 */
class Comment extends Model
{
    /**
     * Provides access to the related user of this comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo - related user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Provides access to the related movie of this comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo - related movie
     */
    public function movie() {
        return $this->belongsTo('App\Movie');
    }
}
