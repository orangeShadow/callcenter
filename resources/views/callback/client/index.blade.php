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
                            <!--<div class="row">
                                <div class="col-sm-6">
                                    <div class="">
                                        <label>Show
                                            <select name="dataTables-example_length"
                                                    aria-controls="dataTables-example"
                                                    class="form-control input-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select> entries
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div id="dataTables-example_filter" class="dataTables_filter">
                                        <label>Search:
                                            <input type="search" class="form-control input-sm" placeholder="" aria-controls="dataTables-example">
                                        </label>
                                    </div>
                                </div>
                            </div>-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-bordered table-hover  no-footer"
                                            role="grid">
                                        <thead>
                                        <tr role="row">
                                            <th>Активность</th>
                                            <th>Название</th>
                                            <th>Ссылка</th>
                                            <th>Линия</th>
                                            <th>Дата Создания</th>
                                            <th>Ключ</th>
                                            <th><a href="{{url('callback/client/create')}}" class="btn btn-success"><i class="fa fa-plus"></i></a></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($clients as $client)
                                                <tr>
                                                    <th>{{$client->active}}</th>
                                                    <th>{{$client->title}}</th>
                                                    <th>{{$client->href}}</th>
                                                    <th>{{$client->sip}}</th>
                                                    <th>{{$client->created_at->format('d.m.Y H:i:s')}}</th>
                                                    <th>{{$client->key}}</th>
                                                    <th><a href="{{url('callback/client',['id'=>$client->id,'edit'])}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a></th>
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