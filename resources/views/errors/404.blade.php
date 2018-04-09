@extends('layouts.message')
@section('title','localhost.acid')
@section('background-url')
@endsection
@section('message')
@if(Auth::check())
<a href='/dashboard' style='text-decoration: none; color: inherit;'>
@else
<a href='/' style='text-decoration: none; color: inherit'>
@endif
404: The requested page was not found on this server.
</a>
@endsection
