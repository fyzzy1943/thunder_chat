@extends('layout')

@section('content')
<div class="jumbotron">
  <div class="container">
    <h1>Welcome!</h1>
    <p>to the thunder chat room</p>
    <p><a class="btn btn-primary btn-lg" href="{{url('/chat')}}" role="button">Chat</a></p>
  </div>
</div>
@endsection