@extends('app')

@section('content')
    <h1>{{$user->name}}</h1>
    <div class="row">
        <div class="col-lg-6">
            <table class="table table-bordered">
                <tr>
                    <th>Телефон</th>
                    <td>{{$user->phone}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <th>Роль</th>
                    <td>{{$user->role->title}}</td>
                </tr>
                <tr>
                    <th>Дата регистрации</th>
                    <td>{{$user->created_at->format('d.m.Y H:i')}}</td>
                </tr>
            </table>
        </div>
    </div>
@stop