<?php

namespace App\Models;

use App\Formable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Log;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'published',
        'visit',
        'submission',
        'share_url'
    ];

    public function parent(): BelongsToMany{
        return $this->belongsToMany(Form::class,'form_id','id');
    }
    public function children(): hasMany{
        return $this->hasMany(Form::class,'form_id','id');
    }
    public function components(): BelongsToMany
    {
        return  $this->belongsToMany(Component::class);
    }
}
