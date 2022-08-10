<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi dengan table scores
    public function score()
    {
        return $this->hasMany('App\Models\Score', 'student_id');
    }
}