@extends('layouts.blank')

@section('content')
<channel-component channel-name="{{$channel->name}}" channel-id="{{$channel->id}}" channel-description="{{$channel->description}}"></channel-component>
@endsection