<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
    ];
    

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['category'] ?? false) {
            if ($filters['category'] == 'all') {
            } else {
                $query->where('category_id', $filters['category']);
            }
        }

        if ($filters['title'] ?? false) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }
    }
}
