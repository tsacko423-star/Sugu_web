<?php

namespace App\Http\Controllers;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function sendToAdmin(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return back()->with('error', 'Aucun administrateur trouvé.');
        }

        $data = [
            'contenu' => $request->contenu,
            'receiver_id' => $admin->id,
        ];

        if (auth()->check()) {
            $data['sender_id'] = auth()->id();
        } else {
            $data['sender_name'] = $request->sender_name;
            $data['sender_email'] = $request->sender_email;
        }

        Message::create($data);

        return back()->with('success', 'Message envoyé à l\'administrateur avec succès.');
    }

    public function inbox()
    {
        $messages = Message::with('sender')
            ->where('receiver_id', auth()->id())
            ->latest()
            ->get();

        return view('messages.inbox', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::with('receiver')
            ->where('sender_id', auth()->id())
            ->latest()
            ->get();

        return view('messages.sent', compact('messages'));
    }

    public function send(Request $request)
    {
        $rules = [
            'receiver_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
        ];

        if (!Auth::check()) {
            $rules['sender_name'] = 'required|string|max:255';
            $rules['sender_email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);

        $data = [
            'receiver_id' => $validated['receiver_id'],
            'contenu' => $validated['contenu'],
        ];

        if (Auth::check()) {
            $data['sender_id'] = Auth::id();
        } else {
            $data['sender_name'] = $validated['sender_name'];
            $data['sender_email'] = $validated['sender_email'];
        }

        Message::create($data);

        return back()->with('success', 'Message envoyé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
