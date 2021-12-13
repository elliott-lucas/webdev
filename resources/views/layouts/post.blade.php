@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('View Post') }}
    </h2>
@endsection

@section('content')
    <p><b>{{ $name }}</b></p>
    <p>{{ $post->text }}</p>
    </br>
    <p>Posted on {{ $post->date_posted }}</p>
    </br>
    <p>Comments:</p>
    </br>
    @foreach ($comments as $comment)
        <p><b>{{ $comment->user->name }}</b></p>
        <p>{{ $comment->text }}</p>
        </br>
    @endforeach
@endsection