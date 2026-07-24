<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['with' => 'required|exists:users,id']);

        $userId = auth()->id();
        $otherId = $request->with;

        $messages = ChatMessage::where(function ($q) use ($userId, $otherId) {
            $q->where('sender_id', $userId)->where('receiver_id', $otherId);
        })->orWhere(function ($q) use ($userId, $otherId) {
            $q->where('sender_id', $otherId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        ChatMessage::where('sender_id', $otherId)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);

        $msg = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($msg->load('sender'), 201);
    }

    public function unreadCount()
    {
        $count = ChatMessage::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['unread' => $count]);
    }

    public function contacts()
    {
        $user = auth()->user();

        if ($user->user_type_id == 2) {
            $contacts = User::where('class_id', $user->class_id)
                ->where('user_type_id', 1)
                ->get(['id', 'fname', 'lname', 'image']);
        } else {
            $contacts = User::where('user_type_id', 2)
                ->when($user->user_type_id == 1, function ($q) use ($user) {
                    $q->where('class_id', $user->class_id);
                })
                ->get(['id', 'fname', 'lname', 'image']);
        }

        return response()->json($contacts);
    }
}
