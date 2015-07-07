@extends('app')

@section('content')
    <h1>{!! Lang::get('user.createUser') !!}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::model($user,['route'=>['user.store'],'class'=>'form-horizontal']) !!}
    <div class="col-lg-12">
        @include('user.form',["submit"=>Lang::get("user.create")])
    </div>
    {!! Form::close() !!}
@stop