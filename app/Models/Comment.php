<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Comment extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    protected $fillable = ['text', 'user_id', 'post_id', 'approved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Photo::class);
    }

    protected $allowedFilters = [
        'approved'
    ];

    protected $allowedSorts = [
        'id',
        'created_at',
        'updated_at'
    ];
}
