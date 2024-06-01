<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'datetime'
    ];

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'event_participant',
            'event_id',
            'user_id',
            'id',
            'id',
        );
    }

    public function priest(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'priest_id',
            'id',
        );
    }

    public function payment(): HasOneThrough
    {
        return $this->hasOneThrough(
            Payment::class,
            EventParticipant::class,
            'event_id',
            'id',
            'id',
            'payment_id'
        );
    }

    public static function getByPriest(User $priest): Collection
    {
        return static::query()
            ->where('priest_id', $priest->id)
            ->get();
    }

    public static function getByPriestForFollowerCalendar(User $priest): Collection
    {
        return static::query()
            ->where('priest_id', $priest->id)
            ->whereDoesntHave('participants')
            ->get();
    }

    public static function getForCurrentUser(): Collection
    {
        return static::query()
            ->whereHas('participants', function (Builder $q) {
                $q->where('users.id', auth()->id());
            })
            ->get();
    }
}
