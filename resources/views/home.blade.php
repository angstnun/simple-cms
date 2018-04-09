@extends('layouts.page')

@section('title', 'localhost.acid')

@section('navbar')
@component('components.home.navbar', ['brand' => 'localhost.acid', 'navbar_items' => $data['navbar_items']])
@endcomponent
@endsection

@section('pageTitle', $data['pageTitle'])

@section('body')
@if($data['body'])
@component('components.body-col', ['extra_classes' => 'body'])
@slot('content')
{!! $data['body']->getContent() !!}
@endslot
@endcomponent
@endif
@endsection

@section('left_bar')
@if($data['left_bar'])
@component('components.body-col', ['extra_classes' => 'left-col some-l-padding'])
@slot('content')
{!! $data['left_bar']->getContent() !!}
@endslot
@endcomponent
@endif
@endsection

@section('right_bar')
@if($data['right_bar'])
@component('components.side-col', ['extra_classes' => 'right-col some-l-padding'])
@slot('searchbar')
@component('components.home.search-bar', ['url' => '/search'])
@endcomponent
@endslot
@slot('content')
{!! $data['right_bar']->getContent() !!}
@endslot
@endcomponent
@endif
@endsection

@section('footer')
@component('components.home.footer', ['footer' => $data['footer']])
@endcomponent
@endsection