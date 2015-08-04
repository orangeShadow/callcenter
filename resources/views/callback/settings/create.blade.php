@extends('layouts.sb-admin')

@section('title')
    {{Lang::get('callback.settings')}}{{$settings->client->title}}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {!! Form::model($settings,['route'=>['callback.settings.store'],'class'=>'form-horizontal','files' => true]) !!}
                @include('callback.settings.form',["submit"=>Lang::get("client.save")],compact('settings'))
            {!! Form::close() !!}
        </div>
    </div>
@stop