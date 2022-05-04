<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model implements Eventable
{
    use HasFactory;
    use HasEvents;

    protected $fillable = [
      'code',
      'data',
      'limit',
      'ends_at'
    ];

    protected $casts = [
        'ends_at' => 'datetime',
    ];

    public function countActivated(): int
    {
        return $this->events()->count();
    }
}
