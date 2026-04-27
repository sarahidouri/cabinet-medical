<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'service_id',
        'appointment_date',
        'status',
        'notes',
    ];

    // Rdv dyalo patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Rdv dyalo medecin
    public function medecin()
    {
        return $this->belongsTo(User::class, 'medecin_id');
    }

    // Rdv dyalo service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}