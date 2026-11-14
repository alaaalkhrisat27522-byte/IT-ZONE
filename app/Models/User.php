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
        'role_id', 'full_name', 'email', 'password_hash', 'student_id',
        'phone', 'avatar', 'department_id', 'academic_year', 'is_active',
        'email_verified_at', 'last_login_at'
    ];

    protected $hidden = [
        'password_hash', 'remember_token'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'academic_year' => 'integer',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role->slug === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role->slug, ['super_admin', 'admin']);
    }

    /**
     * حقل كلمة المرور المخصص (password_hash بدل password).
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
