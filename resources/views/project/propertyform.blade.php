@extends('app')

@section('content')
{!! Form::model($property,['route'=>['property.store'],'class'=>'form-horizontal']) !!}
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!!Form::text('title',null,["class"=>"form-control"])!!}
        </div>
        {!! Form::submit('Отправить',["class"=>"btn btn-primary"]) !!}
    </div>
</div>
{!! Form::close() !!}
@stop