<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'login',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function texts(): HasMany
    {
        return $this->hasMany(Text::class, 'user_id');
    }

    public function isAdmin(): bool
    {
        $role = mb_strtolower($this->role?->name ?? '');
        return in_array($role, ['admin', 'админ', 'администратор']);
    }

    public function isJournalist(): bool
    {
        $role = mb_strtolower($this->role?->name ?? '');
        return in_array($role, ['journalist', 'журналист', 'admin', 'админ', 'администратор']);
    }

    public function hasRole(string ...$roles): bool
    {
        $currentRole = mb_strtolower($this->role?->name ?? '');
        foreach ($roles as $role) {
            $r = mb_strtolower(trim($role));
            if ($r === $currentRole) {
                return true;
            }
            if ($r === 'admin' && in_array($currentRole, ['admin', 'админ', 'администратор'])) {
                return true;
            }
            if ($r === 'journalist' && in_array($currentRole, ['journalist', 'журналист'])) {
                return true;
            }
            if ($r === 'user' && in_array($currentRole, ['user', 'пользователь'])) {
                return true;
            }
        }
        return false;
    }
}
