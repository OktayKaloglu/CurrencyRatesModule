@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('API') }}</div>

                    <div class="form-group1" id="1" >
                        <form method="POST" action="/settings/preferences/add" >
                            {{csrf_field()}}
                            {{method_field('POST')}}

                            <button type="submit"class="btn btn-primary" name="user_id" value={{$user->id}} >Add Api Token</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/settings/preferences/delete">
                            {{csrf_field()}}
                            {{method_field('POST')}}

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Api Token</th>
                                    <th scope="col">/</th>

                                </tr>
                                </thead>

                                @php
                                    use App\Http\Controllers\Auth\UserAuthController as asd;
                                    $user=auth()->user();
                                    $apis=(new asd())->tokensQuery( $user->id);
                                    $row=1;
                                @endphp

                                <tbody>
                                    <tr>

                                    @foreach($apis as $api)

                                            <th scope="row">{{$row}}</th>
                                            <td>{{$api->api_token}}</td>
                                            <td> <button type="submit"  class="btn btn-primary" id={{$api->id}} name="id" value={{$api->id}}>Delete   Token</button></td>

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


