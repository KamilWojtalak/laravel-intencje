<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 'admin';
    const ROLE_PARISH = 'parish';
    const ROLE_USER = 'user';

    const ROLE_ADMIN_STRENGTH = 100;
    const ROLE_PARISH_STRENGTH = 10;
    const ROLE_USER_STRENGTH = 1;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    public static function getByName(string $name): ?self
    {
        return static::query()
            ->where('name', $name)
            ->first();
    }
}
