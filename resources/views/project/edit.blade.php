@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1>{!! Lang::get('project.editProject') !!}</h1>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::model($project,['method'=>'PATCH','action'=>['ProjectController@update',$project->id],'class'=>'form-horizontal']) !!}
                @include('project.form',['submit'=>Lang::get('project.edit')])
            {!! Form::close() !!}
            @if(!empty($project->id))
                <hr>
                <div class="propertyProject row" data-model-goal="Claim" data-model-initiator="Project" data-link-id="{{$project->id}}" ng-app="project-property" ng-controller="propertyController">
                    <div class="col-lg-12">
                        <h4 >Создать свойства для проекта</h4>
                        <form class="form-inline" style="margin-bottom:20px;">
                            <div class="form-group">
                                <label>{{Lang::get("project.propertyTitle")}}</label>
                                <input name="property.title" ng-model="property.title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{Lang::get("project.propertyType")}}</label>
                                <div class="input-group">
                                    <select name="property.type" ng-model="property.type" class="form-control">
                                        <option value="text">{{Lang::get('project.propertyText')}}</option>
                                        <option value="number">{{Lang::get('project.propertyNumber')}}</option>
                                        <option value="date">{{Lang::get('project.propertyDate')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Сортировка</label>
                                <input name="property.sort" ng-model="property.sort" style="width: 50px;" type="text" class="form-control">
                            </div>

                            <a class="btn btn-success btn-sm" ng-click="addProperty()"><i class="glyphicon glyphicon-plus"></i></a>
                        </form>
                        <div class="property-list row">
                            <div class="col-lg-12">
                                <ol>
                                    <li   ng-repeat='property in properties'><% property.title %>, <% property.type %>, <% property.sort %> <a ng-click="deleteProperty($index)" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a> </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @endif
        </div>
    </div>
@stop