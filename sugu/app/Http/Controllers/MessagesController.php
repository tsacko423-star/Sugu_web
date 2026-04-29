<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use Illuminate\Http\Request;

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

    public function send(Request $request)
    {
        Message::create([
            'contenu' => $request->contenu,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
             ]);

        return back();
    }

    public function inbox()
    {
        $messages = Message::where('receiver_id', auth()->id())->get();
        return view('messages.inbox', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', auth()->id())->get();
        return view('messages.sent', compact('messages'));
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
