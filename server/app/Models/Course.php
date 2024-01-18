<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Course extends Model
{
    use HasFactory, HasSlug;

    public $table = 'courses';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'image',
        'course_category_id',
        'published',
        'paid',
        'instructor',
        'totalHours',
        'enrolls',
        'totalRatings'
    ];


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('title');
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function getInstructor()
    {
        return $this->belongsTo(User::class, 'instructor');
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id');
    }

    public function ratings()
    {
        return $this->hasMany(CourseRating::class, 'course_id');
    }
}
