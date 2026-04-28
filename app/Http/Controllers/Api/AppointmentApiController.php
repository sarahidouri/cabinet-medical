<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentApiController extends Controller
{
    // GET /api/appointments
    public function index()
    {
        $appointments = Appointment::with(['patient', 'medecin', 'service'])
            ->latest()
            ->get()
            ->map(function($a) {
                return [
                    'id' => $a->id,
                    'patient' => $a->patient->name,
                    'medecin' => $a->medecin->name,
                    'service' => $a->service->name,
                    'date' => $a->appointment_date,
                    'status' => $a->status,
                ];
            });

        return response()->json($appointments);
    }

    // POST /api/appointments
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'medecin_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'medecin_id' => $request->medecin_id,
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json($appointment, 201);
    }
}