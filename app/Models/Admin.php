<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Support\Collection;
use Filament\Models\Contracts\HasName;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasTenants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements HasName, HasTenants
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'username',
        'phone',
        'email',
        'gender',
        'password',
    ];

    protected $hidden = [
        'password',
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
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFilamentName(): string
    {
        return $this->getAttributeValue('username');
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_admins', 'admin_id', 'school_id');
    }
}
