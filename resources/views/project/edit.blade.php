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
                <div ng-app="project">
                    <hr>
                    <div class="propertyProject row" data-model-goal="Claim" data-model-initiator="Project" data-link-id="{{$project->id}}"  ng-controller="propertyController">
                        <div class="col-lg-12">
                            <h4 >Создать свойства для проекта</h4>
                            <form class="form-inline property" style="margin-bottom:20px;" >
                                <div class="form-group">
                                    <label>{{Lang::get("project.propertyTitle")}}</label>
                                    <input name="property.title" ng-model="property.title" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.propertyXML_CODE")}}</label>
                                    <input name="property.code" ng-model="property.code" type="text" class="form-control">
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
                                        <li   ng-repeat='property in properties'><% property.title %>, <% property.type %>,[<% property.code %>] <% property.sort %> <a ng-click="deleteProperty($index)" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a> </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="destinationProject row"  data-project-id="{{$project->id}}" ng-app="project-destination" ng-controller="destinationController">
                        <div class="col-lg-12">
                            <h4 >Создать адресатов</h4>
                            <form class="form-inline destination" style="margin-bottom:20px;" >
                                <div class="form-group">
                                    <label>{{Lang::get("project.destinationTitle")}}</label>
                                    <input name="destination.title" ng-model="destination.title" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.destinationEmail")}}</label>
                                    <input name="destination.email" ng-model="destination.email" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.sort")}}</label>
                                    <input name="destination.sort" ng-model="destination.sort" style="width: 50px;" type="text" class="form-control">
                                </div>
                                <a class="btn btn-success btn-sm" ng-click="addDestination()"><i class="glyphicon glyphicon-plus"></i></a>
                            </form>
                            <div class="destination-list row">
                                <div class="col-lg-12">
                                    <ol>
                                        <li   ng-repeat='destination in destinations'><% destination.sort %>: <% destination.title %>(<% destination.email %>)<a ng-click="deleteDestination($index)" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a> </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="typicalDescriptionProject row"  data-project-id="{{$project->id}}" ng-app="project-typicalDescription" ng-controller="typicalDescriptionController">
                        <div class="col-lg-12">
                            <h4 >Создать типовое описание</h4>
                            <form class="form-inline typicalDescription" style="margin-bottom:20px;" >
                                <div class="form-group">
                                    <label>{{Lang::get("project.typicalDescription.Description")}}</label>
                                    <textarea style="width:400px;" name="typicalDescription.description" ng-model="typicalDescription.description" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.sort")}}</label>
                                    <input name="typicalDescription.sort" ng-model="typicalDescription.sort" style="width: 50px;" type="text" class="form-control">
                                </div>
                                <a class="btn btn-success btn-sm" ng-click="addDestination()"><i class="glyphicon glyphicon-plus"></i></a>
                            </form>
                            <div class="destination-list row">
                                <div class="col-lg-12">
                                    <ol>
                                        <li   ng-repeat='typicalDescription in typicalDescriptions'><% typicalDescription.sort %>: <% typicalDescription.description %><a ng-click="deleteTypicalDescription($index)" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a> </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            @endif
        </div>
    </div>
@stop