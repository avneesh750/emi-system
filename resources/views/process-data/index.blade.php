@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Process Data</h1>
    <form method="POST" action="{{ url('/process-data') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Process Data</button>
    </form>
</div>
@endsection