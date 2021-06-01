<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    const ACTIVE = 'active';
    const COMPLETED = 'completed';
    const CREATED = 'created';
    const ARCHIVED = 'archived';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
