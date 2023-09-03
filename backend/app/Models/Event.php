<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'eventable_type',
        'eventable_id',
        'user_id',
        'is_read',
    ];

    public function eventable(): MorphTo
    {
        return $this->morphTo();
    }
}
