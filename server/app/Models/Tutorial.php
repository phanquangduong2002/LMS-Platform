<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tutorial extends Model
{
    use HasFactory, HasSlug;

    public $table = 'tutorials';


    protected $fillable = [
        'title',
        'slug',
        'tutorial_category_id',
        'content'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function keywords()
    {
        return $this->hasMany(TutorialKeyword::class, 'tutorial_id');
    }

    // public function getKeywordsAttribute()
    // {
    //     return $this->keywords()->pluck('keyword')->toArray();
    // }

    public function category()
    {
        return $this->belongsTo(TutorialCategory::class, 'tutorial_category_id');
    }
}
