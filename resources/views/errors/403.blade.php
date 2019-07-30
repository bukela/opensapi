@extends('layouts.app')


@section('content')
    <div class="container error-page">
        <h2 class="headline text-info"> 403</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> You are not authorized</h3>
            <p>
                If you want to access this page login first <a href="/login">login</a>
            </p>
        </div>
    </div>
@endsection