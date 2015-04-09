@extends('app')

@section('content')
    <h1>{{$user->name}}</h1>
    <div class="row">
        <div class="col-lg-6">
            <table class="table table-bordered">
                <tr>
                    <th>{{Lang::get("user.phone")}}</th>
                    <td>{{$user->phone}}</td>
                </tr>
                <tr>
                    <th>{{Lang::get("user.email")}}</th>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <th>{{Lang::get("user.send_email")}}</th>
                    <td>{{$user->send_email}}</td>
                </tr>
                <tr>
                    <th>{{Lang::get("user.role")}}</th>
                    <td>{{$user->role->title}}</td>
                </tr>
                <tr>
                    <th>{{Lang::get('create_at')}}</th>
                    <td>{{$user->created_at->format('d.m.Y H:i')}}</td>
                </tr>
            </table>
        </div>
    </div>
@stop