<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_INIT = 'init';
    const STATUS_VERIFIED = 'verified';

    protected $guarded = [];
}
