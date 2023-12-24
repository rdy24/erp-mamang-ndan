<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $guarded = [];

    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function getEmployeeCountAttribute()
    {
        return $this->employees()->count();
    }
}
