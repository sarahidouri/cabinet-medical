<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\AppointmentConfirmation;
use Illuminate\Support\Facades\Mail;


class AppointmentController extends Controller
{
    // Lista dyal rdv
    public function index()
{
    $appointments = Appointment::with(['patient', 'medecin', 'service'])->latest()->paginate(10);
    $medecins = User::where('role', 'medecin')->get();
    $services = Service::all();
    return view('appointments.index', compact('appointments', 'medecins', 'services'));
}

    // Formulaire jdid
    public function create()
    {
        $services = Service::all();
        $medecins = User::where('role', 'medecin')->get();
        return view('appointments.create', compact('services', 'medecins'));
    }

    // Sauvegarder rdv jdid
    public function store(Request $request)
    {
        $request->validate([
            'medecin_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'medecin_id' => $request->medecin_id,
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Mail::to(auth()->user()->email)->send(new AppointmentConfirmation($appointment));
        return redirect()->route('appointments.index')->with('success', 'Rendez-vous créé avec succès!');
    }

    // Formulaire edit
    public function edit(Appointment $appointment)
    {
        $services = Service::all();
        $medecins = User::where('role', 'medecin')->get();
        return view('appointments.edit', compact('appointment', 'services', 'medecins'));
    }

    // Sauvegarder edit
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'medecin_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Rendez-vous modifié avec succès!');
    }

    // Supprimer rdv
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Rendez-vous supprimé!');
    }


    public function search(Request $request)
{
    $query = $request->get('q');
    
    $appointments = Appointment::with(['patient', 'medecin', 'service'])
        ->where(function($q) use ($query) {
            $q->whereHas('patient', fn($q) => $q->where('name', 'like', "%$query%"))
              ->orWhereHas('medecin', fn($q) => $q->where('name', 'like', "%$query%"))
              ->orWhereHas('service', fn($q) => $q->where('name', 'like', "%$query%"));
        })
        ->latest()
        ->get();

    return response()->json($appointments->map(function($a) {
        return [
            'id' => $a->id,
            'patient' => $a->patient->name,
            'medecin' => $a->medecin->name,
            'service' => $a->service->name,
            'date' => $a->appointment_date,
            'status' => $a->status,
        ];
    }));
}

}
