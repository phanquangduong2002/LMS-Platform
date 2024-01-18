<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;

    public $table = 'course_lessons';

    protected $fillable = [
        'course_id',
        'title',
        'video_url'
    ];
}
