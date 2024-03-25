<?php

namespace App\Models;

use App\Formable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Text extends Model
{
    use HasFactory;
    protected $fillable = ['title','component_id'];
    public function component(): BelongsTo
    {
        return $this->BelongsTo(Text::class);
    }
}
