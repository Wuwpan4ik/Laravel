@extends('layouts.app')

@section('content')
@if (Auth::user())
    <a href="user/{{Auth::user()->id}}">Страница</a>
@endif
@endsection
