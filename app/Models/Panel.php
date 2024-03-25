<?php

namespace App\Models;

use App\Formable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Panel extends Model
{
    use HasFactory;
    protected $fillable = ['title','cols','span','component_id'];
    public function component(): BelongsTo
    {
        return $this->BelongsTo(Panel::class)->latest();
    }
}
