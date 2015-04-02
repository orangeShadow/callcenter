@extends('app')

@section('content')
    <h1>{!!Lang::get('claim.claimList')!!}</h1>
    @include('claim.filter')

    <br>

    @if($claims->count())
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>{{Lang::get('claim.project')}}</th>
                        <th>{{Lang::get('claim.client')}}</th>
                        <th>{{Lang::get('claim.phone')}}</th>
                        <th>{{Lang::get('claim.status')}}</th>
                        <th>{{Lang::get('claim.created_at')}}</th>
                        <th style="width:1px;">
                         {{--
                            @if (Auth::user()->checkRole(['manager','admin']))
                                <a href="{!! url('/claim/create') !!}" style="display:block" class="btn btn-success btn-sm"> <i class="glyphicon glyphicon-plus"></i></a>
                            @endif
                        </th>
                        --}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($claims as $claim)
                            <tr>
                                <td>{{$claim->id}}</td>
                                <td>{{ !empty($claim->project()->first()->title) ? $claim->project()->first()->title:'' }}</td>
                                <td>{{$claim->name}}</td>
                                <td>{{$claim->phone}}</td>
                                <td>{{$claim->statusT->title}}</td>
                                <td>{{$claim->created_at->format("d.m.Y H:i:s")}}</td>
                                <th>
                                    <div style="white-space: nowrap;">
                                        <a href="{!! url('/claim/'.$claim->id) !!}" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-eye-open"></i></a>
                                        @if (Auth::user()->checkRole(['manager','admin']))
                                            <a href="{!! url('/claim/'.$claim->id.'/edit') !!}" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
                                            {!! Form::open(['method'=>'DELETE','action'=>["ClaimController@destroy",$claim->id],'style'=>'display:inline']) !!}<button  type="submit" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>{!!Form::close()!!}
                                        @endif
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $claims->render() !!}
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-warning">
                    {{Lang::get('claim.filterProjectNotFound')}}
                </div>
            </div>
        </div>
    @endif
@stop