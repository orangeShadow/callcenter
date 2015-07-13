@extends('layouts.sb-admin')

@section('title')
    Черный список
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Список номеров
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
                                            <th>Телефон</th>
                                            <th>Кто добавил</th>
                                            <th>Дата Создания</th>
                                            <th width="130"><a href="{{url('callback/blacklist/create')}}" class="btn btn-success"><i class="fa fa-plus"></i></a></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($blacklist as $phone)
                                                <tr>
                                                    <th>{{$phone->phone}}</th>
                                                    <th>{{$phone->user->name}}</th>
                                                    <th>{{$phone->created_at->format('d.m.Y H:i:s')}}</th>
                                                    <th>
                                                        {!! Form::open(['method'=>'DELETE','action'=>["Callback\BlacklistController@destroy",$phone->id],'style'=>'display:inline']) !!}<button title="{{Lang::get('project.remove')}}"  type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>{!!Form::close()!!}
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
                                        {!! $blacklist->appends(Input::all())->render() !!}
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