@extends('layouts.sb-admin')

@section('title')
    Лог {{$log->id}}, сайт: {{$log->client->title}}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Телефон</th>
                            <td>{{$log->phone}}</td>
                        </tr>
                        <tr>
                            <th>IP</th>
                            <td>{{$log->ip}},
                                @if(!empty($geo->country->name_ru))
                                    {{$geo->country->name_ru}},
                                @endif
                                @if(!empty($geo->region->name_ru))
                                    {{$geo->region->name_ru}},
                                @endif
                                @if(!empty($geo->city->name_ru))
                                    {{$geo->city->name_ru}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Действие инициатор</th>
                            <td>{{$log->initiator}}</td>
                        </tr>
                        <tr>
                            <th>Дата звонка</th>
                            <td>{{$log->created_at->format('d.m.Y H:i:s')}}</td>
                        </tr>
                        @if(!empty($detail))
                            <tr>
                                <th>Подробно о звонке</th>
                                <td>
                                    <ul>
                                        @foreach($detail as $key=>$val)
                                            @if(!is_array($val))
                                                <li>{{$key}}:{{$val}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@stop