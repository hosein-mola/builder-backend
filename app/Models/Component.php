<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Component extends Model
{
    use HasFactory;
    public function panel(): HasOne
    {
        return $this->hasOne(Panel::class);
    }
    public function text(): HasOne
    {
        return $this->hasOne(Text::class);
    }
}
