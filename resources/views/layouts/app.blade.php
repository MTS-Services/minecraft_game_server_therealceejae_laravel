@extends('layouts.base')

@section('app')
    <main class="container content my-5">
        @include('elements.session-al erts')

        @yield('content')
    </main>
@endsection
