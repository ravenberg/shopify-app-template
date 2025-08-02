<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    protected $fillable = ['shop', 'state', 'scope', 'access_token'];
    protected $casts = ['access_token' => 'encrypted'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
