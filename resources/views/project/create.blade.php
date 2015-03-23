@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1>{!! Lang::get('project.createProject') !!}</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {!! Form::model($project,['method'=>'PATCH','action'=>['ProjectController@create'],'class'=>'form-horizontal']) !!}
                @include('project.form',["buttonSend"=>"project.create"])
            {!! Form::close() !!}
        </div>
    </div>
@stop