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
                $parities=$DF->showparity();
            @endphp
            @foreach($parities as $parity)

                <tr>
                    <th scope="row">{{$parity->id}}</th>
                    <td>{{$parity->code}}</td>
                    <td>{{$parity->name}}</td>

                </tr>

            @endforeach

        </tbody>
    </table>
@endsection
