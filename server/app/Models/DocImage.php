<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocImage extends Model
{
    use HasFactory;

    public $table = 'doc_images';

    protected $fillable = [
        'doc_id',
        'image'
    ];
}
