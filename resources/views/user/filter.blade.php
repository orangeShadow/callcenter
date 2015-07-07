<div class="row">
    <div class="col-lg-12">
        <div style="border:2px solid #c0c0c0;border-radius: 5px;padding:10px;">
        <h4><?=Lang::get('project.filter')?></h4>
        {!! Form::open(['method'=>'get']) !!}
            {!! Form::hidden('filter',true) !!}
            <div class="row">
                <div class="col-lg-4">
                    {!! Form::text('name',Request::get('name'),['class'=>'form-control','placeholder'=>'ФИО']) !!}
                </div>
                <div class="col-lg-4">
                    {!! Form::text('email',Request::get('email'),['class'=>'form-control','placeholder'=>'EMAIL']) !!}
                </div>
                <div class="col-lg-4">
                    {!! Form::select('role_id',[''=>'Роль']+\App\Role::orderBy('sort','asc')->get(['id','title'])->lists('title','id'),Request::get('role_id'),['class'=>'form-control','placeholder'=>"Роль"]) !!}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::submit(Lang::get('project.filtering'),["class"=>"btn btn-primary"]) !!}
                        <a class="btn btn-default" href="<?=url('user')?>">{!! Lang::get('user.clearfilter') !!}</a>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>