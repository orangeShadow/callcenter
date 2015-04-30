@extends('app')

@section('content')

    @include('flash::message')

    <h1>{!!Lang::get('project.projectList')!!}</h1>
    @include('project.filter')
    <br>
    <div class="row">
        <div class="col-lg-6">
            Всего найдено: {{$projects->total()}}, на этой странице: {{$projects->count()}}
        </div>
    </div>
    <br>
    @if($projects->count())
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped" id="project">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Название проекта</th>
                        <th>Дата запуска</th>
                        <th>Клиент</th>
                        <th>Менеджер проекта</th>
                        <th>Статус</th>
                        <th class="projectControl" style="width:1px;">
                            @if (Auth::user()->checkRole(['manager','admin']))
                                <a href="{!! url('/project/create') !!}" style="display:block" class="btn btn-success btn-sm"> <i class="glyphicon glyphicon-plus"> Создать проект</i></a>
                            @endif
                        </th>
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
                        <td>{{$project->statusT->title}}</td>
                        <th>
                            <div style="white-space: nowrap;">
                                @if (Auth::user()->checkRole(['manager','admin']))
                                    <a title="{{Lang::get('claim.claimList')}}" class="btn btn-sm btn-primary" href="/claim?project_id={{$project->id}}"><i class="glyphicon glyphicon-star"></i></a>
                                @endif
                                <a title="{{Lang::get('claim.createClaim')}}" href="{!! url('claim/create?project_id='.$project->id) !!}" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-list"></i></a>
                                <a title="{{Lang::get('project.view')}}" href="{!! url('project/'.$project->id) !!}" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>
                                @if (Auth::user()->checkRole(['manager','admin']))
                                    <a title="{{Lang::get('project.editProject')}}" href="{!! url('project/'.$project->id.'/edit') !!}" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                                    {!! Form::open(['method'=>'DELETE','action'=>["ProjectController@destroy",$project->id],'style'=>'display:inline']) !!}<button title="{{Lang::get('project.remove')}}"  type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>{!!Form::close()!!}
                                @endif
                            </div>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {!! $projects->appends(Input::all())->render() !!}
    @else
        @if (Auth::user()->checkRole(['manager','admin']))
        <div class="row">
            <div class="col-lg-2">
                <a href="{!! url('/project/create') !!}"  class="btn btn-success btn-sm"> <i class="glyphicon glyphicon-plus"></i> {!! Lang::get('project.create') !!}</a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-warning">
                    {{Lang::get('project.filterProjectNotFound')}}
                </div>
            </div>
        </div>
    @endif
@stop