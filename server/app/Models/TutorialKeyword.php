<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tutorial;

class TutorialKeyword extends Model
{
    use HasFactory;

    public $table = 'tutorial_keywords';

    protected $fillable = ['keyword', 'tutorial_id'];
}
