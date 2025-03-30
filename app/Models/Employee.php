<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function healthInsurance()
    {
        return $this->belongsTo(HealthInsurance::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
