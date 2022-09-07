@extends('layouts.app')
@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Code</th>
            <th scope="col">Name</th>

        </tr>
        </thead>
        <tbody>
        @php
            use App\Http\Controllers\DatabaseFiller;
            $DF=new DatabaseFiller();
            $vendors=$DF->getVendors();
        @endphp
        @foreach($vendors as $vendor)

            <tr>
                <th scope="row">{{$vendor->id}}</th>
                <td>{{$vendor->code}}</td>
                <td>{{$vendor->name}}</td>

            </tr>

        @endforeach

        </tbody>
    </table>
@endsection
