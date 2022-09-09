@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Currency Preferences') }}</div>

                    <div class="form-group1" id="1" >
                        <form method="POST" action="/settings/preferences/add" >
                            {{csrf_field()}}
                            {{method_field('POST')}}

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="asd">Vendors</label>
                                    <select id="asd" class="form-control" name="vendor">

                                        <option selected>Vendor</option>

                                        @php

                                            use App\Http\Controllers\Queries;
                                            $que=new Queries();
                                            $vendors=$que->getVendors();
                                        @endphp
                                        @foreach($vendors as $vendor)

                                            <option select for="vendor"> {{ $vendor->code  }}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="code">Currency</label>
                                    <select id="code" class="form-control" name="parity">

                                        <option selected>Parity</option>

                                        @php

                                            $parities=$que->getParities();
                                        @endphp
                                        @foreach($parities as $parity)

                                            <option select for="parity"> {{ $parity->code  }}</option>

                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary"  name="id" value={{$user->id}} >Add Preferences</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/settings/preferences/delete">
                            {{csrf_field()}}
                            {{method_field('POST')}}

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Vendor</th>
                                    <th scope="col">Currency</th>
                                    <th scope="col">/</th>

                                </tr>
                                </thead>

                                @php
                                    use App\Http\Controllers\Auth\UserAuthController;
                                    $user=auth()->user();
                                    $apis=(new UserAuthController())->prefQuery( $user->id);
                                    $row=1;
                                    #print_r($apis);
                                @endphp

                                <tbody>
                                <tr>

                                    @foreach($apis as $api)

                                        <th scope="row">{{$api->vendor}}</th>
                                        <td>{{$api->parity}}</td>
                                        <td> <button type="submit"  class="btn btn-primary" id={{$api->id}} name="id" value={{$api->id}}>Delete {{$api->id}}</button></td>

                                </tr>
                                @php
                                    $row++;
                                @endphp

                                @endforeach
                                </tbody>




                                @if (count($errors)>0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                            @endif
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection


