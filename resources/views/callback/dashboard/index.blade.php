@extends('layouts.sb-admin')

@section('title')
    Рабочий стол, Callback
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{\App\ACME\Model\Callback\Client::where('active',1)->get()->count()}}</div>
                            <div>Кол-во сайтов</div>
                        </div>
                    </div>
                </div>
                <a href="/callback/client">
                    <div class="panel-footer">
                        <span class="pull-left">К списку</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@stop