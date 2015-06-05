@extends('layouts.sb-admin')

@section('content')

    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <h1>{!! Lang::get('claim.createClaim') !!}</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {!! Form::model($settings,['method'=>'PATCH','action'=>['Callback\SettingsController@update',$settings->client_id],'class'=>'form-horizontal']) !!}
            @include('callback.settings.form',["submit"=>Lang::get("client.save"),compact('settings')])
            {!! Form::close() !!}
        </div>
    </div>
@stop