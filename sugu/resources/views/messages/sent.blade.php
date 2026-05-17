@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">Messages envoyés</h1>
            <p class="text-secondary mb-0">Historique des messages que vous avez envoyés.</p>
        </div>
        <a href="{{ route('messages.inbox') }}" class="btn btn-outline-dark">
            <i class="bi bi-inbox"></i> Messages reçus
        </a>
    </div>

    @if($messages->count() > 0)
        <div class="list-group">
            @foreach($messages as $message)
                <div class="list-group-item">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <h5 class="mb-1">
                            À :
                            @if($message->receiver)
                                {{ $message->receiver->name }}
                            @else
                                Destinataire inconnu
                            @endif
                        </h5>
                        <small class="text-secondary">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <p class="mb-0 mt-3">{{ $message->contenu }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mb-0">Aucun message envoyé.</div>
    @endif
</div>
@endsection
