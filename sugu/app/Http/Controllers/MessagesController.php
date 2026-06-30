<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function send(Request $request)
    {
        $rules = [
            'receiver_id' => ['required', 'exists:users,id'],
            'contenu' => ['required', 'string'],
        ];

        if (!$request->user()) {
            $rules['sender_name'] = ['required', 'string', 'max:255'];
            $rules['sender_email'] = ['required', 'email', 'max:255'];
        }

        $validated = $request->validate($rules);

        Message::create([
            'sender_id' => $request->user()?->id,
            'receiver_id' => $validated['receiver_id'],
            'sender_name' => $validated['sender_name'] ?? null,
            'sender_email' => $validated['sender_email'] ?? null,
            'contenu' => $validated['contenu'],
        ]);

        return back()->with('success', 'Message envoye.');
    }

    public function sendToAdmin(Request $request)
    {
        $admin = \App\Models\User::query()->oldest()->firstOrFail();

        $request->validate([
            'contenu' => ['required', 'string'],
        ]);

        Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $admin->id,
            'contenu' => $request->input('contenu'),
        ]);

        return back()->with('success', 'Message envoye a l administrateur.');
    }

    public function inbox()
    {
        return view('messages.inbox', [
            'messages' => Message::with('sender')
                ->where('receiver_id', auth()->id())
                ->latest()
                ->get(),
        ]);
    }

    public function sent()
    {
        return view('messages.sent', [
            'messages' => Message::with('receiver')
                ->where('sender_id', auth()->id())
                ->latest()
                ->get(),
        ]);
    }

    public function index()
    {
        return $this->inbox();
    }

    public function show($id)
    {
        $message = Message::with(['sender', 'receiver'])->findOrFail($id);

        return view('messages.show', compact('message'));
    }
}
