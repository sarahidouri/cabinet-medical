@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📅 Rendez-vous</h2>
        <a href="{{ route('appointments.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nouveau RDV
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 text-left">Patient</th>
                <th class="p-3 text-left">Médecin</th>
                <th class="p-3 text-left">Service</th>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">Statut</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr class="border-t">
                <td class="p-3">{{ $appointment->patient->name }}</td>
                <td class="p-3">{{ $appointment->medecin->name }}</td>
                <td class="p-3">{{ $appointment->service->name }}</td>
                <td class="p-3">{{ $appointment->appointment_date }}</td>
                <td class="p-3">{{ $appointment->status }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('appointments.edit', $appointment) }}" 
                       class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>
                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $appointments->links() }}</div>
</div>
@endsection