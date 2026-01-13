<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki banyak artikel
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Relasi: User memiliki banyak activity log
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Helper: cek apakah user admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper: cek apakah user editor
     */
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    /**
     * Filament: Tentukan siapa yang boleh mengakses panel/dashboard
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Opsi 1 - Paling direkomendasikan (menggunakan helper yang sudah ada)
        // return $this->isAdmin();

        // Opsi 2 - Langsung pakai field role
        // return $this->role === 'admin';

        // Opsi 3 - Boleh lebih dari satu role (contoh)
        return in_array($this->role, ['admin', 'editor']);

        // Opsi 4 - Multi-panel (jika pakai >1 panel)
        // return $this->isAdmin() || $panel->getId() === 'editor-panel';
    }
}
