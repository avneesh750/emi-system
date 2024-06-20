@extends('layouts.app')

@section('content')
<div class="container">
    <h1>EMI Details</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Client ID</th>
                <!-- Dynamically add the month columns -->
                @foreach($emiDetails->first() as $column => $value)
                    @if($column !== 'clientid')
                        <th>{{ str_replace('_', ' ', $column) }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($emiDetails as $detail)
            <tr>
                <td>{{ $detail->clientid }}</td>
                @foreach($detail as $column => $value)
                    @if($column !== 'clientid')
                        <td>{{ $value }}</td>
                    @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection