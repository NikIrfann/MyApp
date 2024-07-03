<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Format the date attribute
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
