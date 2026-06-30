@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="card p-4">
        <h1 class="h3 mb-3">Message</h1>

        <p class="mb-1">
            <strong>De:</strong>
            {{ $message->sender?->name ?? $message->sender_name ?? 'Visiteur' }}
        </p>
        @if($message->sender_email)
            <p class="mb-1"><strong>Email:</strong> {{ $message->sender_email }}</p>
        @endif
        <p class="mb-4"><strong>Date:</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>

        <div class="border rounded p-3 mb-4">
            {{ $message->contenu }}
        </div>

        <a href="{{ route('messages.inbox') }}" class="btn btn-outline-dark">Retour</a>
    </div>
</div>
@endsection
