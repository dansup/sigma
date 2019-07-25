<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\{
	Channel,
	User
};

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
}
