@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1>{!! Lang::get('claim.editClaim') !!}</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::model($claim,['method'=>'PATCH','action'=>['ClaimController@update',$claim->id],'class'=>'form-horizontal']) !!}
            @include('claim.form')
            {!! Form::close() !!}

        </div>
    </div>
@stop