@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1>{!! Lang::get('user.editUser') !!} {{$user->name}}</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {!! Form::model($user,['method'=>'PATCH','action'=>['UserController@update',$user->id],'class'=>'form-horizontal']) !!}
            @include('user.form',["submit"=>Lang::get("user.create")])
            {!! Form::close() !!}
        </div>
    </div>
@stop