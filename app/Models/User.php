<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'employee_no',
        'branch_id',
        'is_active',
        'last_login_at',
        'password',
        'avatar',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class, 'assigned_to');
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'created_by');
    }

     /**
     * accessor avatar user
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null ? asset('/storage/avatars/' . $value) : asset('avatar.png'),
        );
    }

    /**
     *  get all permissions users
     */
    public function getPermissions()
    {
        return $this->getAllPermissions()->mapWithKeys(function($permission){
            return [
                $permission['name'] => true
            ];
        });
    }

    /**
     * check role isSuperAdmin
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }
}
