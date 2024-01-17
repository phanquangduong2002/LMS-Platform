<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Documentation extends Model
{
    use HasFactory, HasSlug;

    public $table = 'documentations';

    protected $fillable = [
        'title',
        'slug',
        'author',
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
        return $this->hasMany(DocKeyword::class, 'doc_id');
    }

    public function images()
    {
        return $this->hasMany(DocImage::class, 'doc_id');
    }
}
