@extends('layouts.admin')
    <style>
        :root {
            --sugu-bg: #0a0f1a;
            --sugu-panel: #111827;
            --sugu-border: #243244;
            --sugu-text: #f8fafc;
            --sugu-muted: #9aa8bd;
            --sugu-accent: #f97316;
            --sugu-info: #3b82f6;
        }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: var(--sugu-text);
            background:
                radial-gradient(circle at 20% 10%, rgba(59, 130, 246, 0.18), transparent 26rem),
                radial-gradient(circle at 82% 30%, rgba(249, 115, 22, 0.16), transparent 22rem),
                var(--sugu-bg);
        }

        .access-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
        }

        .access-panel {
            width: min(100%, 760px);
            background: rgba(17, 24, 39, 0.88);
            border: 1px solid var(--sugu-border);
            border-radius: 8px;
            padding: clamp(1.5rem, 4vw, 3rem);
            box-shadow: 0 24px 80px rgba(0, 0, 0, 0.35);
        }

        .access-icon {
            width: 72px;
            height: 72px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(249, 115, 22, 0.14);
            color: var(--sugu-accent);
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .access-code {
            color: var(--sugu-accent);
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.82rem;
        }

        .access-title {
            font-size: clamp(2rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1;
            margin: 0.75rem 0 1rem;
        }

        .access-text {
            color: var(--sugu-muted);
            font-size: 1.05rem;
            max-width: 58ch;
        }

        .access-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .btn-access-primary,
        .btn-access-secondary {
            border-radius: 8px;
            padding: 0.75rem 1.1rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-access-primary {
            background: var(--sugu-accent);
            color: white;
            border: 1px solid var(--sugu-accent);
        }

        .btn-access-primary:hover {
            background: #ea580c;
            color: white;
        }

        .btn-access-secondary {
            color: var(--sugu-text);
            border: 1px solid var(--sugu-border);
            background: rgba(255, 255, 255, 0.04);
        }

        .btn-access-secondary:hover {
            border-color: var(--sugu-info);
            color: white;
        }
    </style>
</head>
<body>
    <main class="access-page">
        <section class="access-panel">
            <div class="access-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div class="access-code">Erreur 403</div>
            <h1 class="access-title">Acces refuse</h1>

            <p class="access-text">
                Cette partie est reservee aux administrateurs. Votre compte est bien connecte,
                mais il n'a pas les droits necessaires pour utiliser cette fonctionnalite.
            </p>

            <div class="access-actions">
                <a href="{{ route('dashboard') }}" class="btn-access-primary">
                    <i class="bi bi-speedometer2"></i>
                    Retour au dashboard
                </a>
                <a href="{{ route('home') }}" class="btn-access-secondary">
                    <i class="bi bi-house"></i>
                    Accueil
                </a>
            </div>
        </section>
    </main>
</body>
</html>
