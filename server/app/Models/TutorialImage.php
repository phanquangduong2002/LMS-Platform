<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorialImage extends Model
{
    use HasFactory;

    public $table = 'tutorial_images';

    protected $fillable = [
        'tutorial_id',
        'tutorial_image',
    ];
}
