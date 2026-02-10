<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Presenters\PostPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'published',
        'status',
    ];

    protected $casts = [
        'status' => PostStatus::class,
    ];

    public function present()
    {
        return new PostPresenter($this);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
