@extends('layouts.app')

@section('content')
    Your email has successfully been verified. You will redirected to home in 5 seconds

    <script>
        window.setTimeout(function(){
            window.location('/');
        }, 5000);
    </script>
@endsection
