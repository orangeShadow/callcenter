@extends('app')

@section('content')
    <h1>Заявка №{{ $claim->id }}</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('claim.operator') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->operator()->first()->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('claim.project') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->project()->first()->title }},
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('claim.name') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('claim.phone') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->phone }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('claim.text') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->text }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('claim.note') }}</b></div>
                <div class="col-lg-5">
                    {{ $claim->note }}
                </div>
            </div>
        </div>
    </div>
@stop
