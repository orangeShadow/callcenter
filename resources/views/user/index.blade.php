@extends('app')

@section('content')
    <h1>{!!Lang::get('user.userList')!!}</h1>


    @if($users->count())
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped" id="project">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Роль</th>
                        <th>Дата создания</th>
                        <th style="width:1px;">
                            <a href="{!! url('user/create') !!}" class="btn btn-sm btn-success" style="display: block"><i class="glyphicon glyphicon-plus"></i> <i class="glyphicon glyphicon-user"></i></a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><a href="{!! url('user/'.$user->id) !!}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->role->title}}</td>
                            <td>{{$user->created_at->format("d.m.Y H:i:s")}}</td>
                            <th>
                                <div style="white-space: nowrap;">
                                    <a title="{{Lang::get('user.view')}}" href="{!! url('user/'.$user->id) !!}" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>
                                    <a title="{{Lang::get('user.edit')}}" href="{!! url('user/'.$user->id.'/edit') !!}" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                                    {!! Form::open(['method'=>'DELETE','action'=>["UserController@destroy",$user->id],'style'=>'display:inline']) !!}<button title="{{Lang::get('user.remove')}}"  type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>{!!Form::close()!!}
                                </div>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $users->appends(Input::all())->render() !!}
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