@extends('layouts.sb-admin')

@section('title')
    {{Lang::get('client.create')}}
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


            {!! Form::model($client,['route'=>['callback.client.store'],'class'=>'form-horizontal']) !!}
                @include('callback.client.form',["submit"=>Lang::get("client.create")],compact('client'))
            {!! Form::close() !!}
        </div>
    </div>
@stop