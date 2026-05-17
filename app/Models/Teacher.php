<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'qualification',
        'department',
        'bio',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
