@extends('layouts.app')

@section('content')

<h1 class="text-center">{{ $title }}</h1>

<ul>
@foreach ($data as $key => $value)
    <li>{{ $key }} : <a href='https://decathlon.fr/{{ $value }}'>cliquez</a></li>
@endforeach
</ul>

@endsection