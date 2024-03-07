<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
