@extends('layouts.sb-admin')

@section('title')
    {{Lang::get('callback.addtoblacklist')}}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {!! Form::model($phone,['route'=>['callback.blacklist.store'],'class'=>'form-horizontal']) !!}
                @include('callback.blacklist.form',["submit"=>Lang::get("callback.addtoblacklist")],compact('phone'))
            {!! Form::close() !!}
        </div>
    </div>
@stop