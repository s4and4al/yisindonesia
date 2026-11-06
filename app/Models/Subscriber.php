<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasUuids;

    protected $fillable = [
        'email', 'name', 'consent_at', 'confirmed_at', 'unsubscribed_at', 'token',
    ];

    protected function casts(): array
    {
        return [
            'consent_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }
}
