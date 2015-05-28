@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2>{{$claim->project->title}}</h2>
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


            {!! Form::model($claim,['route'=>['claim.store'],'class'=>'form-horizontal']) !!}
                @include('claim.form',["submit"=>Lang::get("claim.create"),'createStatus'=>true])
                <div class="form-group">
                    @foreach($claim->getDestinations() as $destination)

                                    <label class="checkbox-inline"><input type="checkbox" name="destination[]" value="{{$destination->email}}"> {{$destination->title}}</label>

                    @endforeach
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop