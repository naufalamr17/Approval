<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingUser extends Model
{
    use HasFactory;

    protected $table = 'onboarding_user';

    protected $fillable = [
        'id_ticket',
        'nama',
        'job_level',
        'organization',
    ];

    /**
     * Get the ticket request that owns the onboarding user.
     */
    public function ticketRequest()
    {
        return $this->belongsTo(TicketRequest::class, 'id_ticket');
    }
}
