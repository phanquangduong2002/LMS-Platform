<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CourseLesson extends Model
{
    use HasFactory, HasSlug;

    public $table = 'course_lessons';

    protected $fillable = [
        'course_id',
        'title',
        'video',
        'video_duration',
        'free_preview'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
