<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const PROVIDER_STRIPE = 'stripe';
    const PROVIDER_PRZELEWY24 = 'przelewy24';

    const STATUS_INIT = 'init';
    const STATUS_VERIFIED = 'verified';

    protected $guarded = [];
}
