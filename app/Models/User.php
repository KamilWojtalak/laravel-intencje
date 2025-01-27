<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const DASHBOARD_PRIEST_ROUTE_NAME = 'dashboard.priest.index';
    const DASHBOARD_FOLLOWER_ROUTE_NAME = 'dashboard.follower.index';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function prists(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'priest_follower', 'follower_id', 'priest_id')
            ->withPivot('is_accepted');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'priest_follower', 'priest_id', 'follower_id')
            ->withPivot('is_accepted');
    }

    public static function getPriests(): Collection
    {
        return User::query()
            ->whereHas('roles', function (Builder $q) {
                $q->where('name', Role::ROLE_PARISH);
            })
            ->get();
    }

    public function getRoleName(): string
    {
        return $this->roles->first()->name;
    }

    public function getDashboardRouteName(): string
    {
        $roleName = $this->getRoleName();

        if ($roleName === Role::ROLE_PARISH) {
            $dashboardRouteName = static::DASHBOARD_PRIEST_ROUTE_NAME;
        } else {
            $dashboardRouteName = static::DASHBOARD_FOLLOWER_ROUTE_NAME;
        }

        return $dashboardRouteName;
    }

    public function hasNotThisFollower(User $follower): bool
    {
        return !$this->hasThisFollower($follower);
    }

    public function hasThisFollower(User $follower): bool
    {
        return $this->followers->contains('id', $follower->id);
    }

    public function getPriestFollowerById(int $followerId): ?User
    {
        return $this->followers->where('id', $followerId)->first();
    }

    public function priestAcceptFollower(User $follower): int
    {
        return $this
            ->followers()
            ->updateExistingPivot(
                $follower->id,
                ['is_accepted' => 1]
            );
    }

    public function isAcceptedByPriest(): bool
    {
        return $this
            ->prists()
            ->first()
            ->pivot
            ->is_accepted;
    }

    public function hasPriestAssigned(): bool
    {
        return $this
            ->prists()
            ->exists();
    }

    public function hasNotPriestAssigned(): bool
    {
        return !$this
            ->hasPriestAssigned();
    }

    public function isFollower(): bool
    {
        return $this
            ->getRoleName() === Role::ROLE_USER;
    }

    public function isPriest(): bool
    {
        return $this
            ->getRoleName() === Role::ROLE_PARISH;
    }

    public function isNotPriest(): bool
    {
        return !$this
            ->isPriest();
    }
}
