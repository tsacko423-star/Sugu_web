@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Boîte de réception</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($messages->count() > 0)
        <div class="list-group">
            @foreach($messages as $message)
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            @if($message->sender)
                                {{ $message->sender->name }}
                            @else
                                {{ $message->sender_name }} ({{ $message->sender_email }})
                            @endif
                        </h5>
                        <small>{{ $message->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                    <p class="mb-1">{{ $message->contenu }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun message reçu.</p>
    @endif
</div>
@endsection