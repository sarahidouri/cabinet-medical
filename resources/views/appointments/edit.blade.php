@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">✏️ Modifier Rendez-vous</h2>

    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Médecin</label>
            <select name="medecin_id" class="w-full border rounded p-2">
                @foreach($medecins as $medecin)
                    <option value="{{ $medecin->id }}" 
                        {{ $appointment->medecin_id == $medecin->id ? 'selected' : '' }}>
                        {{ $medecin->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Service</label>
            <select name="service_id" class="w-full border rounded p-2">
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        {{ $appointment->service_id == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Date</label>
            <input type="datetime-local" name="appointment_date" 
                   value="{{ $appointment->appointment_date }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Notes</label>
            <textarea name="notes" class="w-full border rounded p-2" rows="3">{{ $appointment->notes }}</textarea>
        </div>

        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
            Modifier RDV
        </button>
    </form>
</div>
@endsection