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
        'flight_time_end',
        'status',
        'price',
        'remarks',
        'jenis_tiket',
        'destination',
        'ticket_screenshot',
        'creator',
        'status_approval'
    ];

    public function onboardingUsers()
    {
        return $this->hasMany(OnboardingUser::class, 'id_ticket');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }

    public function onboardingUser()
{
    return $this->belongsTo(OnboardingUser::class, 'id', 'id_ticket');
}
}
