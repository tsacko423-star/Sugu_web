<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use App\Models\Category;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function dashboard()
    {
        $monthLabels = collect(range(1, 12))->map(function (int $month): string {
            return Carbon::create(null, $month)->translatedFormat('M');
        });

        $annoncesByMonth = Annonce::query()
            ->whereYear('created_at', now()->year)
            ->get(['created_at'])
            ->groupBy(fn (Annonce $annonce) => $annonce->created_at->month)
            ->map->count();

        $categories = Category::query()
            ->leftJoin('annonces', 'categories.id', '=', 'annonces.categorie_id')
            ->select('categories.id', 'categories.name', DB::raw('COUNT(annonces.id) as annonces_count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('categories.name')
            ->get();
        $salesByCategory = $this->salesByCategory();

        return view('dashboard.admin', [
            'totalUsers' => User::count(),
            'totalAnnonces' => Annonce::count(),
            'totalMessages' => Message::count(),
            'totalCategories' => Category::count(),
            'usersTrend' => $this->growthPercentage(User::class),
            'annoncesTrend' => $this->growthPercentage(Annonce::class),
            'messagesTrend' => $this->growthPercentage(Message::class),
            'categoriesTrend' => $this->growthPercentage(Category::class),
            'recentAnnonces' => Annonce::with(['categorie', 'user'])->latest()->take(5)->get(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentActivities' => $this->recentActivities(),
            'monthLabels' => $monthLabels,
            'annoncesChartData' => collect(range(1, 12))->map(fn (int $month) => (int) ($annoncesByMonth[$month] ?? 0)),
            'categoryChartLabels' => $categories->pluck('name'),
            'categoryChartData' => $categories->pluck('annonces_count')->map(fn ($count) => (int) $count),
            'categorySalesLabels' => $salesByCategory->pluck('category_name'),
            'categorySalesData' => $salesByCategory->pluck('total_sales')->map(fn ($total) => (float) $total),
            'userRoleLabels' => collect(['Administrateurs', 'Utilisateurs', 'Vendeurs']),
            'userRoleData' => $this->userRoleDistribution(),
            'orderStatusLabels' => collect(['Livrees', 'En attente', 'Annulees']),
            'orderStatusData' => $this->orderStatusDistribution(),
        ]);
    }

    private function growthPercentage(string $modelClass): int
    {
        $currentMonthCount = $modelClass::query()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        $previousMonthCount = $modelClass::query()
            ->whereBetween('created_at', [
                now()->subMonthNoOverflow()->startOfMonth(),
                now()->subMonthNoOverflow()->endOfMonth(),
            ])
            ->count();

        if ($previousMonthCount === 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        return (int) round((($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100);
    }

    private function recentActivities(): Collection
    {
        $annonces = Annonce::with('user')->latest()->take(5)->get()->map(function (Annonce $annonce) {
            return (object) [
                'type' => 'new-annonce',
                'icon' => 'megaphone-fill',
                'title' => 'Nouvelle annonce',
                'description' => $annonce->titre.' par '.($annonce->user->name ?? 'Utilisateur'),
                'created_at' => $annonce->created_at,
            ];
        });

        $users = User::latest()->take(5)->get()->map(function (User $user) {
            return (object) [
                'type' => 'new-user',
                'icon' => 'person-plus-fill',
                'title' => 'Nouvel utilisateur',
                'description' => $user->name.' s\'est inscrit',
                'created_at' => $user->created_at,
            ];
        });

        $messages = Message::with(['sender', 'receiver'])->latest()->take(5)->get()->map(function (Message $message) {
            return (object) [
                'type' => 'message',
                'icon' => 'chat-dots-fill',
                'title' => 'Nouveau message',
                'description' => ($message->sender->name ?? $message->sender_name ?? 'Visiteur').' a contacté '.($message->receiver->name ?? 'un utilisateur'),
                'created_at' => $message->created_at,
            ];
        });

        return $annonces
            ->merge($users)
            ->merge($messages)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();
    }

    private function salesByCategory(): Collection
    {
        $sales = Annonce::query()
            ->leftJoin('categories', 'categories.id', '=', 'annonces.categorie_id')
            ->select(DB::raw('COALESCE(categories.name, "Non classe") as category_name'), DB::raw('SUM(annonces.prix) as total_sales'))
            ->groupBy('categories.name')
            ->orderBy('category_name')
            ->get();

        if ($sales->isEmpty()) {
            return collect([(object) ['category_name' => 'Aucune donnee', 'total_sales' => 0]]);
        }

        return $sales;
    }

    private function userRoleDistribution(): Collection
    {
        $roles = User::query()
            ->select(DB::raw('LOWER(COALESCE(role, "user")) as role_name'), DB::raw('COUNT(*) as total'))
            ->groupBy('role_name')
            ->pluck('total', 'role_name')
            ->map(fn ($total) => (int) $total);

        $admins = (int) ($roles['admin'] ?? 0);
        $vendors = (int) (($roles['vendeur'] ?? 0) + ($roles['seller'] ?? 0));
        $users = max(0, User::count() - $admins - $vendors);

        return collect([$admins, $users, $vendors]);
    }

    private function orderStatusDistribution(): Collection
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

        $counts = DB::table($table)
            ->select($statusColumn, DB::raw('COUNT(*) as total'))
            ->groupBy($statusColumn)
            ->pluck('total', $statusColumn)
            ->mapWithKeys(fn ($total, $status) => [strtolower((string) $status) => (int) $total]);

        $delivered = $counts->only(['livree', 'livrees', 'livré', 'livrés', 'delivered'])->sum();
        $pending = $counts->only(['en attente', 'attente', 'pending'])->sum();
        $cancelled = $counts->only(['annulee', 'annulees', 'annulé', 'annulés', 'cancelled', 'canceled'])->sum();

        return collect([$delivered, $pending, $cancelled]);
    }

    public function index()
    {
        return $this->dashboard();
    }

    public function users()
    {
        return redirect()->route('admin.dashboard');
    }

    public function annonces()
    {
        return redirect()->route('annonces.index');
    }

    public function categories()
    {
        return redirect()->route('categories.index');
    }

    public function settings()
    {
        return redirect()->route('admin.dashboard');
    }
}
