@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Messages envoyés</h1>
    @if($messages->count() > 0)
        <div class="list-group">
            @foreach($messages as $message)
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            @if($message->receiver)
                                {{ $message->receiver->name }}
                            @else
                                Destinataire inconnu
                            @endif
                        </h5>
                        <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <p class="mb-1">{{ $message->contenu }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun message envoyé.</p>
    @endif
</div>
@endsection