<?php

namespace Forum\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @property int    $id
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package Forum\Models
 */
class Post extends Model
{
    protected $fillable = [
        'topic_id', 'user_id', 'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}