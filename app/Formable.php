<?php

namespace App;
use App\Models\Form;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Formable extends MorphPivot
{
    public $incrementing = false; // this is the default value. Change if you need to.
    public $guarded = [];         // this is the default value. Change if you need to.
    protected $table = 'formables';

    public function formable()
    {
        return $this->morphTo();
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
