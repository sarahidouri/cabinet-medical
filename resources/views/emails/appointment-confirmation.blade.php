@component('mail::message')
# Confirmation de Rendez-vous

Bonjour **{{ $appointment->patient->name }}**,

Votre rendez-vous a été confirmé avec les détails suivants :

| | |
|---|---|
| **Médecin** | {{ $appointment->medecin->name }} |
| **Service** | {{ $appointment->service->name }} |
| **Date** | {{ $appointment->appointment_date }} |
| **Statut** | {{ $appointment->status }} |

Merci de votre confiance.

{{ config('app.name') }}
@endcomponent