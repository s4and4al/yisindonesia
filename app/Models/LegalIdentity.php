<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalIdentity extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'label', 'value', 'is_public', 'sort_order'];

    protected function casts(): array
    {
        return ['is_public' => 'boolean'];
    }
}
