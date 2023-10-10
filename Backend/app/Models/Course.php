<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public function enrollments(): HasMany {
        return $this->hasMany(Enrollment::class);
    }

    public function timeslots(): HasMany {
        return $this->hasMany(Timeslot::class);
    }
}
