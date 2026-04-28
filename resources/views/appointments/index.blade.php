@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📅 Rendez-vous</h2>
        <button onclick="openCreateModal()" 
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    + Nouveau RDV
</button>
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
                    <button onclick="openDeleteModal({{ $appointment->id }})" 
        class="bg-red-500 text-white px-3 py-1 rounded">
    Delete
</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $appointments->links() }}</div>
</div>


{{-- Delete Modal --}}
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h3 class="text-lg font-bold mb-4">⚠️ Confirmer la suppression</h3>
        <p class="text-gray-600 mb-6">Vous êtes sûr de vouloir supprimer ce rendez-vous?</p>
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()" 
                    class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                Annuler
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
function openDeleteModal(id) {
    document.getElementById('deleteForm').action = '/appointments/' + id;
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>




// Modale d'ajout rapide

{{-- Create Modal --}}
<div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h3 class="text-lg font-bold mb-4">➕ Nouveau Rendez-vous</h3>
        
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Médecin</label>
                <select name="medecin_id" class="w-full border rounded p-2">
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}">{{ $medecin->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Service</label>
                <select name="service_id" class="w-full border rounded p-2">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Date</label>
                <input type="datetime-local" name="appointment_date" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Notes</label>
                <textarea name="notes" class="w-full border rounded p-2" rows="3"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" 
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Annuler
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Créer RDV
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    const modal = document.getElementById('createModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection