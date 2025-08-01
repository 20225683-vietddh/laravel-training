<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'email',
    //     'password',
    //     'first_name',
    //     'last_name',
    //     'is_active',
    //     'username',
    // ];
    protected $guarded = [
        'is_admin',
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
    ];

    public function tasks(): HasMany {
        return $this->hasMany(Task::class);
    }

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }


    protected function fullName(): Attribute {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->last_name,
        );
    }

    protected function username(): Attribute {
        return Attribute::make(
            set: fn ($value) => Str::slug($value),
        );
    }
}
