<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Filament\Models\Contracts\HasName;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasName, HasTenants
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fname',
        'mname',
        'lname',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->schools;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->schools->contains($tenant);
    }

    public function getFullName() {
        return $this->fname . ' ' . $this->lname;
    }

    public function getFilamentName(): string
    {
        // if (is_null($this->fname) && is_null($this->lname) && is_null($this->username)) {
        //     return $this->getAttributeValue('email');
        // } elseif (is_null($this->fname) && is_null($this->lname)) {
        //     return $this->getAttributeValue('username');
        // } elseif (is_null($this->fname)) {
        //     return $this->getAttributeValue('lname');
        // } elseif (is_null($this->lname)) {
        //     return $this->getAttributeValue('fname');
        // } else {
        //     return $this->getAttributeValue('name');
        // }

        return $this->getAttributeValue('name');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_users', 'user_id', 'school_id');
    }
}
