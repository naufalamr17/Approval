<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'no_surat',
        'name',
        'nik',
        'start_date',
        'end_date',
        'transportation',
        'accommodation',
        'allowance',
        'cash_advance_amount',
        'total_amount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'transportation' => 'array',
        'accommodation' => 'array',
        'allowance' => 'array',
        'cash_advance_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
}
