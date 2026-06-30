<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $userAnnonces = Annonce::with('categorie')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.user', [
            'totalAnnonces' => Annonce::where('user_id', $user->id)->count(),
            'totalMessages' => Message::where('receiver_id', $user->id)->count(),
            'unreadMessages' => Message::where('receiver_id', $user->id)->whereNull('read_at')->count(),
            'userAnnonces' => $userAnnonces,
            'recentActivities' => $this->recentActivities($user->id),
            'statsCharts' => $this->statsCharts($user),
        ]);
    }

    private function recentActivities(int $userId): Collection
    {
        $annonces = Annonce::where('user_id', $userId)->latest()->take(5)->get()->map(function (Annonce $annonce) {
            return [
                'type' => 'view',
                'icon' => 'megaphone-fill',
                'title' => 'Annonce publiée',
                'description' => $annonce->titre,
                'time' => $annonce->created_at->diffForHumans(),
                'created_at' => $annonce->created_at,
            ];
        });

        $messages = Message::with('sender')
            ->where('receiver_id', $userId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Message $message) {
                return [
                    'type' => 'message',
                    'icon' => 'chat-dots-fill',
                    'title' => $message->read_at ? 'Message reçu' : 'Nouveau message',
                    'description' => 'De : '.($message->sender->name ?? $message->sender_name ?? 'Visiteur'),
                    'time' => $message->created_at->diffForHumans(),
                    'created_at' => $message->created_at,
                ];
            });

        return $annonces
            ->merge($messages)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();
    }

    private function statsCharts(User $user): array
    {
        $monthLabels = collect(range(1, 12))->map(function (int $month): string {
            return Carbon::create(null, $month)->translatedFormat('M');
        });

        $annoncesByMonth = Annonce::query()
            ->where('user_id', $user->id)
            ->whereYear('created_at', now()->year)
            ->get(['created_at'])
            ->groupBy(fn (Annonce $annonce) => $annonce->created_at->month)
            ->map->count();

        $salesByCategory = Annonce::query()
            ->leftJoin('categories', 'categories.id', '=', 'annonces.categorie_id')
            ->where('annonces.user_id', $user->id)
            ->select(DB::raw('COALESCE(categories.name, "Non classe") as category_name'), DB::raw('SUM(annonces.prix) as total_sales'))
            ->groupBy('categories.name')
            ->orderBy('category_name')
            ->get();

        $salesLabels = $salesByCategory->pluck('category_name');
        $salesData = $salesByCategory->pluck('total_sales')->map(fn ($total) => (float) $total);

        if ($salesLabels->isEmpty()) {
            $salesLabels = collect(['Aucune donnee']);
            $salesData = collect([0]);
        }

        return [
            'annoncesLabels' => $monthLabels,
            'annoncesData' => collect(range(1, 12))->map(fn (int $month) => (int) ($annoncesByMonth[$month] ?? 0)),
            'salesLabels' => $salesLabels,
            'salesData' => $salesData,
            'userRoleLabels' => collect(['Administrateurs', 'Utilisateurs', 'Vendeurs']),
            'userRoleData' => $this->roleDistributionForUser($user),
            'orderStatusLabels' => collect(['Livrees', 'En attente', 'Annulees']),
            'orderStatusData' => $this->orderStatusDistribution($user->id),
        ];
    }

    private function roleDistributionForUser(User $user): Collection
    {
        $role = strtolower((string) $user->role);

        return collect([
            $role === 'admin' ? 1 : 0,
            in_array($role, ['admin', 'vendeur', 'seller'], true) ? 0 : 1,
            in_array($role, ['vendeur', 'seller'], true) ? 1 : 0,
        ]);
    }

    private function orderStatusDistribution(int $userId): Collection
    {
        $table = Schema::hasTable('commandes') ? 'commandes' : (Schema::hasTable('orders') ? 'orders' : null);

        if (!$table) {
            return collect([0, 0, 0]);
        }

        $statusColumn = collect(['statut', 'status', 'etat'])
            ->first(fn (string $column) => Schema::hasColumn($table, $column));

        if (!$statusColumn) {
            return collect([0, 0, 0]);
        }

        if (!Schema::hasColumn($table, 'user_id')) {
            return collect([0, 0, 0]);
        }

        $query = DB::table($table)->where('user_id', $userId);

        $counts = $query
            ->select($statusColumn, DB::raw('COUNT(*) as total'))
            ->groupBy($statusColumn)
            ->pluck('total', $statusColumn)
            ->mapWithKeys(fn ($total, $status) => [strtolower((string) $status) => (int) $total]);

        $delivered = $counts->only(['livree', 'livrees', 'livré', 'livrés', 'delivered'])->sum();
        $pending = $counts->only(['en attente', 'attente', 'pending'])->sum();
        $cancelled = $counts->only(['annulee', 'annulees', 'annulé', 'annulés', 'cancelled', 'canceled'])->sum();

        return collect([$delivered, $pending, $cancelled]);
    }

    public function profile()
    {
        return view('profile.edit');
    }

    public function settings()
    {
        return view('profile.settings');
    }
}
