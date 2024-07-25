<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'poh',
        'jenis',
        'start_date',
        'end_date',
        'flight_date',
        'route',
        'departure_airline',
        'flight_time',
        'status',
        'price',
        'remarks',
        'ticket_screenshot',
        'creator',
        'status_approval'
    ];
}
