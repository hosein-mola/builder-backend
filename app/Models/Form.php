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

class Form extends Model
{
    use HasFactory;

    public function parent(): BelongsToMany{
        return $this->belongsToMany(Form::class,'form_id','id');
    }
    public function children(): hasMany{
        return $this->hasMany(Form::class,'form_id','id');
    }
    public function panels()
    {
        return $this->morphedByMany(Panel::class, 'taggable')->using(Formable::class);
    }

    public function textFields()
    {
        return $this->morphedByMany(TextField::class, 'taggable')->using(Formable::class);
    }
}
