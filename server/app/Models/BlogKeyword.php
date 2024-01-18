<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogKeyword extends Model
{
    use HasFactory;

    public $table = 'blog_keywords';

    protected $fillable = ['keyword', 'blog_id'];
}
