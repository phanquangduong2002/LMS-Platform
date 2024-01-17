<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocKeyword extends Model
{
    use HasFactory;

    public $table = 'doc_keywords';

    protected $fillable = [
        'doc_id',
        'keyword'
    ];
}
