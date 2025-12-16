<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'user_id',
        'salutation',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'phone',
        'address_line',
        'city',
        'state',
        'country',
        'pin_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
        ];
    }

    /**
     * Get role name (backward compatibility)
     */
    public function getRoleNameAttribute()
    {
        return $this->roles()->first()?->name ?? $this->attributes['role'] ?? null;
    }
    
    /**
     * Check if user has a specific role (backward compatibility)
     * This method checks both Spatie roles and the role field
     */
    public function hasRoleName($role): bool
    {
        // Check Spatie roles first
        if ($this->roles()->where('name', $role)->exists()) {
            return true;
        }
        
        // Also check the role field for backward compatibility
        return $this->attributes['role'] === $role;
    }
}
