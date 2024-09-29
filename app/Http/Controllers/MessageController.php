<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\SendMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Support\Facades\Request;

class MessageController extends Controller
{

    public function getPenerima($recipientId)
    {

        $messages = Message::where(function ($query) use ($recipientId) {
            $query->where('user_id', auth()->id())
                ->where('recipient_id', $recipientId);
        })
            ->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }
    public function getPengirim(User $user, Message $message)
    {
        return response()->json($user);
    }

    public function getChatRoom(User $user, $recipientId)
    {
        $user = $user->with(['recipient'])->find($recipientId);

        $sender = [];
        foreach ($user->recipient as $key => $value) {
            $sender[$value->user_id] = User::find($value->user_id);
        }
        return response()->json(array_values($sender));
    }
    public function index($recipientId)
    {
        $messages = Message::where(function ($query) use ($recipientId) {
            $query->where('user_id', auth()->id())
                ->where('recipient_id', $recipientId);
        })
            ->orWhere(function ($query) use ($recipientId) {
                $query->where('user_id', $recipientId)
                    ->where('recipient_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function store(StoreMessageRequest $request, User $user)
    {
        $user = User::find($request->recipient_id);
        $message = Message::create([
            'user_id' => auth()->id(),
            'nama_pengirim' => Auth::user()->name,
            'nama_penerima' => $user->name,
            'recipient_id' => $request->recipient_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        $user = User::find($request->recipient_id);

        // Siarkan event ke pengguna lain (akan kita buat)
        // broadcast(new SendMessage($message, $user->id))->toOthers();
        Log::info('Message sent by user ' . auth()->id() . ' to user ' . $request->recipient_id . ': ' . $request->message);
        return response()->json($message);
    }

    public function update(Message $message, User $user, $recipientId)
    {
        $messages = Message::where(function ($query) use ($recipientId) {
            $query->where('user_id', $recipientId)
                ->where('recipient_id', auth()->id());
        })
            ->orderBy('created_at', 'asc')->update(['is_read' => true]);

        return response()->json("Berhasil");
    }
}
