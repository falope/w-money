<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $casts = [
        'meta' => 'object'
    ];

    public function getRoi(int $unit): int
    {
        $roi = 0;
        if (!isset($this->meta)) return 0;
        foreach ((object) json_decode($this->meta) as $meta) {
            list($a, $b) = $meta->range;
            if ($b > 0) {
                if ($unit >= $a && $unit <= $b) {
                    $roi = $meta->roi;
                }
            } else {
                if ($unit >= $a) {
                    $roi = $meta->roi;
                }
            }
        };
        return $roi;
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
