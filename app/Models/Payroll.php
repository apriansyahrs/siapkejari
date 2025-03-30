<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setPeriodAttribute($value)
    {
        $this->attributes['period'] = Carbon::parse('01-'.$value)->format('Y-m-1');
    }

    public function setPaymentDateAttribute($value)
    {
        $this->attributes['payment_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
