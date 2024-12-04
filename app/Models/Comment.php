<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function posts():BelongsTo{
        return $this->belongsTo(Post::class);
    }
    public function users():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function likes():MorphMany{
        return $this->morphMany(Like::class,"likeable");
    }
    public function replies():HasMany{
        return $this->hasMany(self::class,"parent_id");
    }

}