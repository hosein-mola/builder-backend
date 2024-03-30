<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class Component extends Model
{
    use HasFactory,HasUlids;

    protected $fillable = ['id','type','page','parentId','extraAttributes'];
    protected $casts = [
        'extraAttributes' => 'array',
    ];

    public function forms(): BelongsToMany
    {
        return  $this->belongsToMany(Form::class);
    }

}
