@extends('app')

@section('content')
    <h1>{{ $project->title }}</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('project.manager') }}</b></div>
                <div class="col-lg-5">
                    {{ $project->manager()->first()->name }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('project.client') }}</b></div>
                <div class="col-lg-5">
                    {{ $project->client()->first()->name }},
                    {{ $project->client()->first()->phone }},
                    <a href="mailto:{{ $project->client()->first()->email }}">{{ $project->client()->first()->email }}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('project.text') }}</b></div>
                <div class="col-lg-5">
                    {{ $project->text }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-1"><b>{{ Lang::get('project.note') }}</b></div>
                <div class="col-lg-5">
                    {{ $project->note }}
                </div>
            </div>
        </div>
    </div>
@stop
