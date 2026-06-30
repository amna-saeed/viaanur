<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TeacherUser extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('role', function (Builder $builder) {
            $builder->where('role', self::ROLE_TEACHER);
        });
    }

    public function teacherProfile(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }
}
