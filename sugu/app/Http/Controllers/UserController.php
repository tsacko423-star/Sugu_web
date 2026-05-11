<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Annonce;
use App\Models\Message;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user annonces (last 5)
        $userAnnonces = Annonce::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Calculate statistics
        $totalAnnonces = Annonce::where('user_id', $user->id)->count();
        $totalViews = 0; // Views column doesn't exist yet, can be added later
        $totalMessages = Message::where('receiver_id', $user->id)->count();
        
        // Get unread messages/notifications
        $unreadMessages = Message::where('receiver_id', $user->id)->count();
        $unreadNotifications = 0; // You can implement notifications later
        
        // Recent activities
        $recentActivities = $this->getRecentActivities($user);
        
        return view('dashboard.user', [
            'userAnnonces' => $userAnnonces,
            'totalAnnonces' => $totalAnnonces,
            'totalViews' => $totalViews,
            'totalMessages' => $totalMessages,
            'unreadMessages' => $unreadMessages,
            'unreadNotifications' => $unreadNotifications,
            'recentActivities' => $recentActivities,
        ]);
    }
    
    private function getRecentActivities($user)
    {
        $activities = [];
        
        // Get recent annonces
        $recentAnnonces = Annonce::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
        
        foreach ($recentAnnonces as $annonce) {
            $activities[] = [
                'type' => 'view',
                'icon' => 'eye-fill',
                'title' => 'Nouvelle annonce publiée',
                'description' => $annonce->titre,
                'time' => $annonce->created_at->diffForHumans(),
            ];
        }
        
        // Get recent messages
        $recentMessages = Message::where('receiver_id', $user->id)
            ->latest()
            ->take(2)
            ->get();
        
        foreach ($recentMessages as $msg) {
            $activities[] = [
                'type' => 'message',
                'icon' => 'chat-fill',
                'title' => 'Nouveau message',
                'description' => 'De: ' . ($msg->sender->name ?? 'Utilisateur'),
                'time' => $msg->created_at->diffForHumans(),
            ];
        }
        
        // Sort by time (most recent first)
        usort($activities, function($a, $b) {
            return strcmp($b['time'], $a['time']);
        });
        
        return array_slice($activities, 0, 5);
    }
}
