@extends('layouts.sb-admin')

@section('title')
    Список клиентов
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Таблица клиентов
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <div id="dataTables-example_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-bordered table-hover  no-footer"
                                            role="grid">
                                        <thead>
                                        <tr role="row">
                                            <th class="hidden-xs hidden-sm hidden-md">Активность</th>
                                            <th>Название</th>
                                            <th class="hidden-xs hidden-sm hidden-md">Ссылка</th>
                                            <th class="hidden-xs hidden-sm hidden-md">Линия</th>
                                            <th class="hidden-xs hidden-sm hidden-md">Дата Создания</th>
                                            <th>Ключ</th>
                                            <th width="166"><a href="{{url('callback/client/create')}}" class="btn btn-success" style="width:100%"><i class="fa fa-plus"></i></a></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($clients as $client)
                                                <tr>
                                                    <th class="hidden-xs hidden-sm hidden-md">{{$client->active? 'Да':'Нет'}}</th>
                                                    <th>{{$client->title}}</th>
                                                    <th class="hidden-xs hidden-sm hidden-md">{{$client->href}}</th>
                                                    <th class="hidden-xs hidden-sm hidden-md">{{$client->sip}}</th>
                                                    <th class="hidden-xs hidden-sm hidden-md">{{$client->created_at->format('d.m.Y H:i:s')}}</th>
                                                    <th class="">{{$client->key}}</th>
                                                    <th>
                                                        <a href="{{url('callback/client',['id'=>$client->id,'edit'])}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                                        <a href="{{url('callback/settings',['id'=>$client->id,'edit'])}}" class="btn btn-sm btn-primary"><i class="fa fa-gears"></i></a>
                                                        <a href="{{url('callback/logs?id='.$client->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-area-chart"></i></a>
                                                        {!! Form::open(['method'=>'DELETE','action'=>["Callback\ClientController@destroy",$client->id],'style'=>'display:inline']) !!}<button title="{{Lang::get('project.remove')}}"  type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>{!!Form::close()!!}
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_info" id="dataTables-example_info" role="status"
                                         aria-live="polite"><!--Показано с 1 to 20 of 57 entries-->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        {!! $clients->appends(Input::all())->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@stop