<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public static function getByPriest(User $priest): Collection
    {
        return static::query()
            ->where('priest_id', $priest->id)
            ->get();
    }
}
