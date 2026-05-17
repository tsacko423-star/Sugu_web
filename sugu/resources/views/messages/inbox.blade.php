@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">Messages reçus</h1>
            <p class="text-secondary mb-0">Les messages envoyés par les visiteurs, les vendeurs et les utilisateurs.</p>
        </div>
        <a href="{{ route('messages.sent') }}" class="btn btn-outline-dark">
            <i class="bi bi-send"></i> Messages envoyés
        </a>
    </div>

    @if($messages->count() > 0)
        <div class="list-group">
            @foreach($messages as $message)
                <div class="list-group-item">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                        <div>
                            <h5 class="mb-1">
                                @if($message->sender)
                                    {{ $message->sender->name }}
                                @else
                                    {{ $message->sender_name ?? 'Visiteur' }}
                                @endif
                            </h5>

                            @if(!$message->sender && $message->sender_email)
                                <small class="text-secondary">{{ $message->sender_email }}</small>
                            @endif
                        </div>
                        <small class="text-secondary">{{ $message->created_at->format('d/m/Y H:i') }}</small>
                    </div>

                    <p class="my-3">{{ $message->contenu }}</p>

                    @if($message->sender)
                        <form action="{{ route('messages.send') }}" method="POST" class="border-top pt-3">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $message->sender_id }}">

                            <label for="reply-{{ $message->id }}" class="form-label">Répondre</label>
                            <textarea
                                name="contenu"
                                id="reply-{{ $message->id }}"
                                class="form-control mb-2"
                                rows="2"
                                placeholder="Votre réponse..."
                                required
                            ></textarea>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-reply"></i> Envoyer la réponse
                            </button>
                        </form>
                    @elseif($message->sender_email)
                        <div class="border-top pt-3">
                            <a href="mailto:{{ $message->sender_email }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-envelope"></i> Répondre par email
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mb-0">Aucun message reçu.</div>
    @endif
</div>
@endsection
