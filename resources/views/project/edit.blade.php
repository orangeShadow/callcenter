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
                                            <option value="select">{{Lang::get('project.propertySelect')}}</option>
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
                                        <li  ng-repeat='property in properties' ng-inut="parent_id = $index">
                                            <% property.title %>, <% property.type %>,[<% property.code %>] <% property.sort %>
                                            <a style="margin-right: 5px;" data-toggle="modal" data-target="#modal-<%$index%>" ng-if="property.type =='список' || property.type =='select'"><i class="glyphicon glyphicon-edit"></i></a>

                                            <div ng-if="property.type =='список' || property.type =='select'" id="<% 'modal-' + $index %>"  class="modal fade" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title"><%property.title%>, укажите возможные варианты ответа</h4>
                                                        </div>
                                                        <form>
                                                        <div class="modal-body">

                                                            <div class="property-select">
                                                                <div ng-repeat="itemP in property.values track by $index" class="form-group" style="position: relative;">
                                                                    <input class="form-control" type="text" ng-model="property.values[$index]" type="text"> <i ng-click="removePropertyValue($index,$parent.$index)" style="position:absolute;top:10px;right:10px;color:#F00;" class="glyphicon glyphicon-remove"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                                            <button ng-click="addValues($index)"  type="button" class="btn btn-success">Добавить строку</button>
                                                            <button ng-click="saveValues($index)"    type="button" class="btn btn-primary">Сохранить</button>
                                                        </div>
                                                        </form>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div>

                                            <a style="margin-right: 5px;" ng-click="activeProperty($index)" ng-class="{'text-warning':property.active==1,'text-success':property.active==0}">
                                                <i ng-if="property.active==0" title="Отображать свойство" class="glyphicon glyphicon-eye-open"></i>
                                                <i ng-if="property.active==1" title="Скрыть свойство" class="glyphicon glyphicon-eye-close"></i>
                                            </a>
                                            <a ng-click="deleteProperty($index)" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a>
                                        </li>
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

                    <div class="claimTypeProject row"  data-project-id="{{$project->id}}" ng-app="project-claimType" ng-controller="claimTypeController">
                        <div class="col-lg-12">
                            <h4 >Создать тип запроса для заявки</h4>
                            <form class="form-inline claimType" style="margin-bottom:20px;" >
                                <div class="form-group">
                                    <label>{{Lang::get("project.title")}}</label>
                                    <input name="claimType.title" ng-model="claimType.title" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.price")}}</label>
                                    <input name="claimType.price" ng-model="claimType.price" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.send_mail")}}</label>
                                    <input name="claimType.send_mail" ng-model="claimType.send_mail" onclick="if(this.value==0) this.value=1; else this.value=0;" style="margin:5px;" type="checkbox" value="0" >
                                </div>
                                <div class="form-group">
                                    <label>{{Lang::get("project.sort")}}</label>
                                    <input name="claimType.sort" ng-model="claimType.sort" style="width: 50px;" type="text" class="form-control">
                                </div>

                                <a class="btn btn-success btn-sm" ng-click="addClaimType()"><i class="glyphicon glyphicon-plus"></i></a>
                            </form>
                            <div class="typeRequest-list row">
                                <div class="col-lg-12">
                                    <ul>
                                        <li   ng-repeat='claimType in claimTypes'><% claimType.sort %> <% claimType.title %>(<% claimType.price %> р) <% (claimType.send_mail==1) ? "отправлять уведомление":"" %><a ng-click="deleteClaimType($index)" class="text-danger"><i class="glyphicon glyphicon-remove"></i></a> </li>
                                    </ul>
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