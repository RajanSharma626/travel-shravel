<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'country', 'state', 'city', 'description', 'is_active'
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
