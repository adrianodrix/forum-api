<?php

namespace Forum\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Topic
 *
 * @property int    $id
 * @property string $title
 * @property string $slug
 * @property string $text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package Forum\Models
 */
class Topic extends Model
{
    protected $fillable = [
        'title', 'slug', 'body', 'section_id', 'user_id'
    ];

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}