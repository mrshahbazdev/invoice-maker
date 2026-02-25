<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'primary_color',
        'is_active',
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
