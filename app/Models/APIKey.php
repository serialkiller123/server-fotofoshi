<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIKey extends Model
{
    use HasFactory;

    protected $table = 'api_keys';

    protected $fillable = [
        'user_id',
        'key',
    ];

    /**
     * Get the user that owns the APIKey.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
