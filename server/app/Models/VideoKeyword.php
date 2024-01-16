<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoKeyword extends Model
{
    use HasFactory;

    public $table = 'video_keywords';

    protected $fillable = [
        'keyword',
        'video_id'
    ];
}
