@extends('layouts.app')
@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Time</th>
            <th scope="col">Vendor</th>
            <th scope="col">Parity</th>
            <th scope="col">Buy Rate</th>
            <th scope="col">Sell Rate</th>

        </tr>
        </thead>
        <tbody>
        @php
            use App\Http\Controllers\DatabaseFiller;
            $DF=new DatabaseFiller();
            $rates=$DF->getrates();
            $row=0;
        @endphp
        @foreach($rates as $rate)

            <tr>
                <th scope="row">{{$row}}</th>
                <td>{{$rate->time}}</td>
                <td>{{$rate->vendor}}</td>
                <td>{{$rate->parity}}</td>
                <td>{{$rate->buy_rate}}</td>
                <td>{{$rate->sell_rate}}</td>
                @php
                $row++;
                @endphp
            </tr>

        @endforeach

        </tbody>
    </table>
@endsection
