@extends('app')

@section('content')
    <h1>Заявка №{{ $claim->id }}</h1>
    <div class="row">
        <div class="col-lg-12">
            @if(!Auth::user()->checkRole(['client']))
                <div class="row">
                    <div class="col-lg-2"><b>{{ Lang::get('claim.operator') }}</b></div>
                    <div class="col-lg-5">
                        {{ $claim->operator()->first()->name }}
                    </div>
                </div>
                <br>

                @if($claim->updateby)
                    <div class="row">
                        <div class="col-lg-2"><b>{{ Lang::get('claim.update_by') }}</b></div>
                        <div class="col-lg-5">
                            {{ $claim->updateby->name }}
                        </div>
                    </div>
                    <br>
                @endif

                <div class="row">
                    <div class="col-lg-2"><b>{{ Lang::get('claim.update_at') }}</b></div>
                    <div class="col-lg-5">
                        {{ $claim->updated_at->format('d.m.Y H:i') }}
                    </div>
                </div>
                <br>
            @endif
            <div class="row">
                <div class="col-lg-2"><b>{{ Lang::get('claim.project') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->project()->first()->title }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-2"><b>{{ Lang::get('claim.name') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->name }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-2"><b>{{ Lang::get('claim.phone') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->phone }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-2"><b>{{ Lang::get('claim.text') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->text }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-2"><b>{{ Lang::get('claim.backcall_at') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->backcall_at }}
                </div>
            </div>
            @if(!empty($claim->note))
            <div class="row">
                <div class="col-lg-2"><b>{{ Lang::get('claim.note') }}</b></div>
                <div class="col-lg-5">
                    {{$claim->note}}
                </div>
            </div>
            @endif

            <br>
            {!! Form::model($claim,['method'=>'POST','url'=>['claim/statuschange'],'class'=>'form-horizontal']) !!}
            @if(Auth::user()->checkRole(["client"]))
                <div class="form-group">
                    {!! Form::label('note',Lang::get('claim.note'),["class"=>"col-sm-2 control-label"]) !!}
                    <div class="col-lg-5">
                    {!! Form::textarea('note',$claim->note,["class"=>'form-control']) !!}
                    </div>
                </div>
            @endif

            <div class="form-group">
                {!! Form::input('hidden','id',$claim->id) !!}
                {!! Form::label('status',Lang::get('claim.status'),["class"=>"col-sm-2 control-label"]) !!}
                <div class="col-sm-2">
                {!! Form::select('status',\App\StatusClaim::orderBy('sort','asc')->get(['code','title'])->lists('title','code'),Request::get('status'),['class'=>'form-control']) !!}
                </div>
                <div class="col-sm-3">{!! Form::submit(Lang::get('claim.update'),["class"=>"btn btn-default"]) !!}</div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    @foreach(\App\Property::showPropertyValue($claim) as $property)
        <div class="row">
            <div class="col-lg-2"><b>{{$property["title"]}}</b></div>
            <div class="col-lg-5">
                {!! $property["value"] !!}
            </div>
        </div>
    @endforeach
@stop
