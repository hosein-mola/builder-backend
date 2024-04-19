<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['extraAttributes','form_id'];
    public $timestamps = false;
    protected $casts = [
        'extraAttributes' => 'array',
    ];

    public function forms(): BelongsTo
    {
        return  $this->belongsTo(Form::class);
    }
}
