<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    public $table = 'api_keys';

    protected $fillable = ['api_key'];

    public static function isValidApiKey($apiKey)
    {
        return self::where('api_key', $apiKey)->exists();
    }
}
