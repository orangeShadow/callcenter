@extends('layouts.sb-admin')

@section('title')
    Лог звонков
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
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
                                            <th>Дата звонка</th>
                                            <th>Телефон</th>
                                            <th>IP</th>
                                            <th>Инициатор события</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($logs as $log)
                                            <tr>
                                                <th>{{$log->created_at->format('d.m.Y H:i:s')}}</th>
                                                <th>{{$log->phone}}</th>
                                                <th>{{$log->ip}}</th>
                                                <th>{{$log->initiator}}</th>
                                                <th>
                                                    <a href="/callback/logs/{{$log->id}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
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
                                        {!! $logs->appends(Input::all())->render() !!}
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