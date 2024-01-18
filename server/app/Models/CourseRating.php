<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    use HasFactory;

    public $table = 'course_ratings';

    protected $fillable = [
        'course_id',
        'stars',
        'comment',
        'postedBy'
    ];

    public function posted()
    {
        $this->belongsTo(User::class, 'postedBy');
    }
}
