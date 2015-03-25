@extends('app')

@section('content')
    <h1>{!!Lang::get('project.projectList')!!}</h1>
    @include('project.filter')

    <br>

    @if($projects->count())
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Название проекта</th>
                        <th>Дата запуска</th>
                        <th>Клиент</th>
                        <th>Менеджер проекта</th>
                        <th>Статус</th>
                        <th style="width:165px;"><a href="{!! url('/project/create') !!}" style="display:block" class="btn btn-success btn-sm"> <i class="glyphicon glyphicon-plus"></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>{{$project->id}}</td>
                        <td>{{$project->title}}</td>
                        <td>{{$project->created_at->format("d.m.Y H:i:s")}}</td>
                        <td>{{ !empty($project->client()->first()->name) ? $project->client()->first()->name:'' }}</td>
                        <td>{{ !empty($project->manager()->first()->name) ? $project->manager()->first()->name:'' }}</td>
                        <td>{{$project->status}}</td>
                        <th>
                            <a class="btn btn-sm btn-primary" href="/claim?project_id={{$project->id}}"><i class="glyphicon glyphicon-star"></i></a>
                            <a href="{!! url('project/'.$project->id) !!}" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! url('project/'.$project->id.'/edit') !!}" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                            {!! Form::open(['method'=>'DELETE','action'=>["ProjectController@destroy",$project->id],'style'=>'display:inline']) !!}<button  type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>{!!Form::close()!!}
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="row">
            <div class="col-lg-2">
                <a href="{!! url('/project/create') !!}"  class="btn btn-success btn-sm"> <i class="glyphicon glyphicon-plus"></i> {!! Lang::get('project.create') !!}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-warning">
                    {{Lang::get('project.filterProjectNotFound')}}
                </div>
            </div>
        </div>
    @endif
@stop