@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">📅 {{ __('messages.appointments') }}</h2>
        <button onclick="openCreateModal()" 
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            {{ __('messages.new_appointment') }}
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-4">
    <input type="text" id="searchInput" 
           placeholder="Rechercher un rendez-vous..."
           class="w-full border rounded p-2 shadow-sm">
</div>

{{-- Search Bar --}}
<div class="mb-4">
    <input type="text" id="searchInput" 
           placeholder="Rechercher un rendez-vous..."
           class="w-full border rounded p-2 shadow-sm">
</div>

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-50">
            <tr>
                <th class="p-3 text-left">{{ __('messages.patient') }}</th>
                <th class="p-3 text-left">{{ __('messages.medecin') }}</th>
                <th class="p-3 text-left">{{ __('messages.service') }}</th>
                <th class="p-3 text-left">{{ __('messages.date') }}</th>
                <th class="p-3 text-left">{{ __('messages.status') }}</th>
                <th class="p-3 text-left">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody id="appointmentsTable">
            @foreach($appointments as $appointment)
            <tr class="border-t">
                <td class="p-3">{{ $appointment->patient->name }}</td>
                <td class="p-3">{{ $appointment->medecin->name }}</td>
                <td class="p-3">{{ $appointment->service->name }}</td>
                <td class="p-3">{{ $appointment->appointment_date }}</td>
                <td class="p-3">{{ $appointment->status }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('appointments.edit', $appointment) }}" 
                       class="bg-yellow-400 text-white px-3 py-1 rounded">{{ __('messages.edit') }}</a>
                    <button onclick="openDeleteModal({{ $appointment->id }})" 
                            class="bg-red-500 text-white px-3 py-1 rounded">
                        {{ __('messages.delete') }}
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
        <h3 class="text-lg font-bold mb-4">⚠️ {{ __('messages.confirm_delete') }}</h3>
        <p class="text-gray-600 mb-6">{{ __('messages.confirm_message') }}</p>
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()" 
                    class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                {{ __('messages.cancel') }}
            </button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    {{ __('messages.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>

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

{{-- Create Modal --}}
<div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-96">
        <h3 class="text-lg font-bold mb-4">➕ {{ __('messages.new_appointment') }}</h3>
        
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('messages.medecin') }}</label>
                <select name="medecin_id" class="w-full border rounded p-2">
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}">{{ $medecin->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('messages.service') }}</label>
                <select name="service_id" class="w-full border rounded p-2">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('messages.date') }}</label>
                <input type="datetime-local" name="appointment_date" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Notes</label>
                <textarea name="notes" class="w-full border rounded p-2" rows="3"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()" 
                        class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    {{ __('messages.cancel') }}
                </button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    {{ __('messages.save') }}
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




<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value;
    
    axios.get('/appointments/search', {
        params: { q: query }
    })
    .then(function(response) {
        const tbody = document.getElementById('appointmentsTable');
        tbody.innerHTML = '';
        
        response.data.forEach(function(a) {
            tbody.innerHTML += `
                <tr class="border-t">
                    <td class="p-3">${a.patient}</td>
                    <td class="p-3">${a.medecin}</td>
                    <td class="p-3">${a.service}</td>
                    <td class="p-3">${a.date}</td>
                    <td class="p-3">${a.status}</td>
                    <td class="p-3 flex gap-2">
                        <a href="/appointments/${a.id}/edit" 
                           class="bg-yellow-400 text-white px-3 py-1 rounded">Edit</a>
                        <button onclick="openDeleteModal(${a.id})" 
                                class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                    </td>
                </tr>
            `;
        });
    });
});
</script>

@endsection