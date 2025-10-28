<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

     use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'description',
        'default_price',
        'is_active'
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
