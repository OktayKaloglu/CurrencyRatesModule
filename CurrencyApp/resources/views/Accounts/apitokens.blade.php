@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('API') }}</div>

                    <div class="card-body">
                        <form method="POST" action="/settings/account">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{old('name') ?? $user->name}}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{old('email') ?? $user->email }}">
                            </div>

                            <div class="form-group">
                                <button type="submit"class="btn btn-primary">Update Account</button>
                            </div>


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
