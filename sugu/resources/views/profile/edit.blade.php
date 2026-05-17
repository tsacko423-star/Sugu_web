@extends('layouts.admin')

@section('content')
  
<section class="profile-page py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="mb-4">
                    <span class="text-uppercase fw-semibold text-primary small">Mon compte</span>
                    <h1 class="fw-bold mt-2 mb-2">Modifier mon profil</h1>
                    <p class="text-secondary mb-0">Mettez a jour votre nom et changez votre mot de passe.</p>
                </div>

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-md-5">
                                <div class="d-flex align-items-start gap-3 mb-4">
                                    <div class="profile-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <h2 class="h5 fw-bold mb-1">Nom du compte</h2>
                                        <p class="text-secondary mb-0">Ce nom sera affiche sur votre profil et dans votre espace utilisateur.</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="email" value="{{ old('email', $user->email) }}">

                                    <div class="mb-4">
                                        <label for="name" class="form-label fw-semibold">Nom</label>
                                        <input
                                            type="text"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            id="name"
                                            name="name"
                                            value="{{ old('name', $user->name) }}"
                                            required
                                            autocomplete="name"
                                        >
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex align-items-center gap-3 flex-wrap">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check2-circle me-1"></i>
                                            Enregistrer le nom
                                        </button>

                                        @if (session('status') === 'profile-updated')
                                            <span class="text-success fw-semibold">Nom mis a jour.</span>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-md-5">
                                <div class="d-flex align-items-start gap-3 mb-4">
                                    <div class="profile-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    <div>
                                        <h2 class="h5 fw-bold mb-1">Mot de passe</h2>
                                        <p class="text-secondary mb-0">Saisissez votre mot de passe actuel, puis choisissez le nouveau.</p>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label fw-semibold">Mot de passe actuel</label>
                                        <input
                                            type="password"
                                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                            id="current_password"
                                            name="current_password"
                                            required
                                            autocomplete="current-password"
                                        >
                                        @error('current_password', 'updatePassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                                            <input
                                                type="password"
                                                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                                id="password"
                                                name="password"
                                                required
                                                autocomplete="new-password"
                                            >
                                            @error('password', 'updatePassword')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password_confirmation"
                                                name="password_confirmation"
                                                required
                                                autocomplete="new-password"
                                            >
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3 flex-wrap mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-key me-1"></i>
                                            Modifier le mot de passe
                                        </button>

                                        @if (session('status') === 'password-updated')
                                            <span class="text-success fw-semibold">Mot de passe mis a jour.</span>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .profile-page {
        background:
            radial-gradient(circle at top left, rgba(13, 110, 253, 0.08), transparent 32rem),
            #f8fafc;
        min-height: 72vh;
    }

    .profile-page .card {
        border-radius: 8px;
    }

    .profile-icon {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        font-size: 1.25rem;
        flex: 0 0 auto;
    }
</style>
@endpush
