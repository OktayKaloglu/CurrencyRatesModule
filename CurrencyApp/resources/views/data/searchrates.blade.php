@extends('layouts.app')

@section('content')

    <form method="POST" action="/rates/search">
        {{ csrf_field() }}

        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="date">Date</label>
                <input type="text" for="date" name="date" placeholder={{$date=date('m',).'/'.date('d').'/'.date('y')}} class="form-control" id="date" >
            </div>
            <div class="form-group col-md-3">
                <label for="code">Currency</label>
                <select id="code" class="form-control" name="code">

                    <option selected>Parity</option>



                    @php
                        use App\Http\Controllers\Queries;
                       use App\Http\Controllers\Auth\UserAuthController;
                       $que=new Queries();
                       $pref=new UserAuthController();
                       $parities=$pref->prefQuery(auth()->user()->id);
                    @endphp
                    @foreach($parities as $parity)

                        <option select for="code" name="code"> {{ $parity->parity  }}</option>

                    @endforeach
                </select>
            </div>

        </div>
        <button type="submit" class="btn btn-primary"  name="id" value={{$user->id}} >Search</button>

    </form>


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
            $row=1;
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
