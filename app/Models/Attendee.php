<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Attendee extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'course',
        'gender',
        'year_level_id',
        'qr_code_path',
        'has_attended',
        'role',
        'position',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class);
    }
}
