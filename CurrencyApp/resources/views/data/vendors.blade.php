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
            $row =1;
        @endphp
        @foreach($vendors as $vendor)

            <tr>
                <th scope="row">{{$row}}</th>
                <td>{{$vendor->code}}</td>
                <td>{{$vendor->name}}</td>
                @php
                    $row++
                @endphp
            </tr>

        @endforeach

        </tbody>
    </table>
@endsection
