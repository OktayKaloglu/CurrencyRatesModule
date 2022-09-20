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
                use App\Http\Controllers\Queries;
                $DF=new Queries();
                $parities=$DF->showparity();
                $row=1;
            @endphp
            @foreach($parities as $parity)

                <tr>
                    <th scope="row">{{$row}}</th>
                    <td>{{$parity->code}}</td>
                    <td>{{$parity->name}}</td>
                    @php
                        $row++
                    @endphp
                </tr>

            @endforeach

        </tbody>
    </table>
@endsection
