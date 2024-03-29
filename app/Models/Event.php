<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'imagem',
        'emp_id',
        'soda',
        'paid',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'emp_id');
    }
}
