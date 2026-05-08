@extends('layouts.app')

@section('content')
<section class="dashboard-page" style="padding: 3rem 1.5rem; background: #f8fafc; min-height: 80vh;">
    <div class="container" style="max-width: 960px; margin: 0 auto;">
        <div style="background: white; border-radius: 1rem; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08); padding: 2rem;">
            <h1 style="font-size: 2rem; margin-bottom: 0.75rem; color: #111827;">Bienvenue sur votre espace</h1>
            <p style="color: #4b5563; font-size: 1rem; margin-bottom: 2rem;">Ici vous pouvez consulter votre tableau de bord, gérer vos annonces et accéder à votre profil.</p>

            <div style="display: grid; gap: 1.25rem; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                <div style="background: #eef2ff; padding: 1.25rem; border-radius: 1rem;">
                    <h3 style="margin-bottom: 0.5rem; color: #1d4ed8;">Mes annonces</h3>
                    <p style="margin: 0; color: #4b5563;">Consultez, modifiez ou supprimez vos annonces publiées.</p>
                </div>
                <div style="background: #ecfccb; padding: 1.25rem; border-radius: 1rem;">
                    <h3 style="margin-bottom: 0.5rem; color: #65a30d;">Mon profil</h3>
                    <p style="margin: 0; color: #4b5563;">Gérez vos informations personnelles et vos préférences.</p>
                </div>
                <div style="background: #fee2e2; padding: 1.25rem; border-radius: 1rem;">
                    <h3 style="margin-bottom: 0.5rem; color: #dc2626;">Messages</h3>
                    <p style="margin: 0; color: #4b5563;">Accédez à votre boîte de réception et envoyez des messages.</p>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 1rem;">
                <a href="{{ route('annonces.index') }}" style="padding: 0.85rem 1.25rem; background: #2563eb; color: white; border-radius: 0.75rem; text-decoration: none;">Voir mes annonces</a>
                <a href="{{ route('profile.edit') }}" style="padding: 0.85rem 1.25rem; background: #e5e7eb; color: #111827; border-radius: 0.75rem; text-decoration: none;">Modifier mon profil</a>
            </div>
        </div>
    </div>
</section>
@endsection
