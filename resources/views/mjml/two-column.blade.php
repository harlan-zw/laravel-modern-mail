@extends('mjml::default')

@section('main')
    <!-- LHS -->
    <mj-column mj-class="left-column">
        @yield('left')
    </mj-column>
    <!-- RHS -->
    <mj-column mj-class="right-column">
        @yield('right')
    </mj-column>
@endsection
