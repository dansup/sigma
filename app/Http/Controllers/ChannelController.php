<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\{
	Channel,
    Message,
	User
};
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Events\NewChannelMessage;

class ChannelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
    	return view('channel.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|string|min:2|max:20',
    		'description' => 'nullable|string|max:120'
    	]);

    	$name = $request->input('name');
    	$description = $request->input('description');

    	$channel = new Channel();
    	$channel->name = $name;
    	$channel->description = $description;
    	$channel->owner_id = Auth::id();
    	$channel->save();

    	return redirect($channel->adminUrl());
    }

    public function manage(Request $request, $id)
    {
    	$channel = Channel::findOrFail($id);
    	abort_if($channel->owner_id !== Auth::id(), 403);
    	return view('channel.manage', compact('channel'));
    }

    public function show(Request $request, $id)
    {
    	$channel = Channel::findOrFail($id);
    	return view('channel.show', compact('channel'));
    }

    public function messages(Request $request, $id)
    {
        $channel = Channel::findOrFail($id);

        $messages = $channel->messages()->latest()->orderByDesc('created_at')->paginate(10)->map(function($m) {
            return [
                'user' => [
                    'avatar' => 'https://pixelfed.social/storage/avatars/default.png',
                    'username' => $m->owner->username,
                    'url' => $m->owner->url()
                ],
                'message' => [
                    'plaintext' => $m->message,
                    'rendered' => $m->rendered,
                    'timestamp' => $m->created_at->format('c')
                ]
            ];
        });

        return response()->json($messages);
    }

    public function storeMessage(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required|min:1|max:500'
        ]);
        $channel = Channel::findOrFail($id);
        $user = Auth::user();

        $message = new Message();
        $message->channel_id = $channel->id;
        $message->owner_id = $user->id;
        $message->message = $request->input('message');
        $message->rendered = Markdown::convertToHtml($request->input('message'));
        $message->save();

        $res = [
            'user' => [
                'avatar' => 'https://pixelfed.social/storage/avatars/default.png',
                'username' => $user->username,
                'url'   => $user->url()
            ],
            'message' => [
                'plaintext' => $message->message,
                'rendered' => $message->rendered,
                'timestamp' => $message->created_at->format('c')
            ]
        ];

        broadcast(new NewChannelMessage($channel, $message, $res))->toOthers();
        return response()->json($res);
    }
}
