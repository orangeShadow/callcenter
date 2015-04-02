<div class="row">
    <div class=" @if(\Auth::user()->checkRole(['manager','admin'])) col-lg-12 @else col-lg-6 @endif ">
        <div style="border:2px solid #c0c0c0;border-radius: 5px;padding:10px;">
            <h4><?=Lang::get('claim.filter')?></h4>
            {!! Form::open(['method'=>'get']) !!}
            <div class="row">
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif ">
                    <div class="form-group">
                        {!! Form::text('created_at_from',Request::get('created_at_from'),['class'=>'form-control datepicker','placeholder'=>'Дата создания от']) !!}
                        <br>
                        {!! Form::text('created_at_to',Request::get('created_at_to'),['class'=>'form-control datepicker','placeholder'=>'Дата создания по']) !!}
                    </div>
                </div>
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        {!! Form::text('id',Request::get('id'),['class'=>'form-control','placeholder'=>'Номер заявки']) !!}<br>
                        {!! Form::select('status',[0=>'Укажите статус']+\App\StatusClaim::orderBy('sort','asc')->get(['code','title'])->lists('title','code'),Request::get('status'),['class'=>'form-control']) !!}
                    </div>
                </div>
                @if(\Auth::user()->checkRole(['manager','admin']))
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        {!! Form::select('operator_id',[0=>'Кем создана']+\App\User::whereIn('role_id',[2,3])->orderBy('name','asc')->get(['id','name'])->lists('name','id'),Request::get('operator_id'),['class'=>'form-control']) !!}
                        <br>
                        {!! Form::select('project_id',[0=>'Выберите проект']+\App\Project::orderBy('title','asc')->get(['id','title'])->lists('title','id'),Request::get('project_id'),['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        {!! Form::text('name',Request::get('name'),['class'=>'form-control','placeholder'=>Lang::get('claim.name')]) !!}
                        <br>
                        {!! Form::text('phone',Request::get('phone'),['class'=>'form-control','placeholder'=>Lang::get('claim.phone')]) !!}
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                {!! Form::hidden('filter',true) !!}
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::submit(Lang::get('claim.filtering'),["class"=>"btn btn-primary"]) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>