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
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        {!! Form::text('name',Request::get('name'),['class'=>'form-control','placeholder'=>Lang::get('claim.name')]) !!}
                        <br>
                        {!! Form::text('phone',Request::get('phone'),['class'=>'form-control','placeholder'=>Lang::get('claim.phone')]) !!}
                    </div>
                </div>
                @if(\Auth::user()->checkRole(['manager','admin']))
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        {!! Form::select('operator_id',[0=>'Кем создана']+\App\User::whereIn('role_id',[2,3])->orderBy('name','asc')->get(['id','name'])->lists('name','id'),Request::get('operator_id'),['class'=>'form-control']) !!}
                        <br>
                        {!! Form::select('project_id',[0=>'Выберите проект']+\App\Project::orderBy('title','asc')->get(['id','title'])->lists('title','id'),Request::get('project_id'),['class'=>'selectpicker', 'data-live-search'=>"true"]) !!}
                    </div>
                </div>
                @else
                    <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                        <div class="form-group">
                            <?php
                            $projects_id = \Auth::user()->projects->lists('title','id');
                            $createdProjects = \Auth::user()->createProject->lists('title','id');
                                $result_array = [0=>'Выберите проект'] + $projects_id + $createdProjects;
                            ?>
                            {!! Form::select('project_id',$result_array,Request::get('project_id'),['class'=>'form-control']) !!}
                        </div>
                    </div>
                @endif

                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        <label>Звонок сорвался</label>
                        {!!Form::hidden('missed_call',0)!!}
                        {!!Form::checkbox('missed_call',1,Request::get('missed_call'))!!}
                    </div>
                </div>
                <div class="@if(\Auth::user()->checkRole(['manager','admin'])) col-lg-3 @else col-lg-6 @endif">
                    <div class="form-group">
                        <label>Контакты отсутствуют</label>
                        {!!Form::hidden('without_contacts',0)!!}
                        {!!Form::checkbox('without_contacts',1,Request::get('without_contacts'))!!}
                    </div>
                </div>

            </div>
            <div class="row">
                {!! Form::hidden('filter',true) !!}
                @if ( !empty( \Auth::user()->apikey ) )
                    {!! Form::hidden( 'key', \Auth::user()->apikey ) !!}
                @endif

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::submit(Lang::get('claim.filtering'),["class"=>"btn btn-primary"]) !!}
                        @if (!empty(\Auth::user()->apikey) )
                            {!! Form::button('Печать XLS',["class"=>"btn btn-success","id"=>"sendAPI"]) !!}
                        @endif
                        @if ( !empty( \Auth::user()->checkRole(['admin','manager'])) )
                            {!! Form::button('XLS по проекту',["class"=>"btn btn-success","id"=>"sendAPIProject"]) !!}
                        @endif
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section("css")
    <link rel="stylesheet" href="/css/bootstrap-select.min.css">
@stop


@section('scripts');
    <script src="/js/bootstrap-select.min.js"></script>
    <script src="/js/defaults-ru_RU.min.js"></script>

    <script>
        (function(){

            $('.selectpicker').selectpicker();


            serialize = function(obj) {
                var str = [];
                for(var p in obj)
                    if (obj.hasOwnProperty(p)) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                return str.join("&");
            }

            $('#sendAPI').click(function(e){
                e.preventDefault();
                var objURL = {};

                if ($('input[name="created_at_from"]').val().length>0 ){
                    objURL.created_at_from = $('input[name="created_at_from"]').val();
                }

                if ($('input[name="created_at_to"]').val().length>0 ){
                    objURL.created_at_to   = $('input[name="created_at_to"]').val();
                }

                if ($('input[name="key"]').val().length>0 ){
                    objURL.key = $('input[name="key"]').val();
                }


                location.href = '/api/claims?'+serialize(objURL);
            });

            $('#sendAPIProject').click(function(e){
                e.preventDefault();
                var objURL = {};

                objURL.created_at_from = $('input[name="created_at_from"]').val();
                objURL.created_at_to   = $('input[name="created_at_to"]').val();
                objURL.project_id = $('select[name="project_id"]').val();

                if(objURL.project_id.length==0 || objURL.project_id==0) return alert('Выберите проект');
                if(objURL.created_at_from.length==0 && objURL.created_at_to.length==0) return alert('Задайте период времени');

                location.href = '/api/claims/'+objURL.project_id+'?'+serialize(objURL);
            });

        }());
    </script>
@stop