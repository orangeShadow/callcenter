<div class="row">
    <div class="col-lg-12">
        <div style="border:2px solid #c0c0c0;border-radius: 5px;padding:10px;">
        <h4><?=Lang::get('project.filter')?></h4>
        {!! Form::open(['method'=>'get']) !!}
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    {!! Form::text('created_at_from',Request::get('created_at_from'),['class'=>'form-control','placeholder'=>'Дата создания от']) !!}
                    <br>
                    {!! Form::text('created_at_to',Request::get('created_at_to'),['class'=>'form-control','placeholder'=>'Дата создания по']) !!}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    {!! Form::text('title',Request::get('title'),['class'=>'form-control','placeholder'=>'Название']) !!}
                    <br>
                    {!! Form::text('id',Request::get('id'),['class'=>'form-control','placeholder'=>'Номер']) !!}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    {!! Form::text('client_id',Request::get('client_id'),['class'=>'form-control','placeholder'=>'Менеджер']) !!}
                    <br>
                    {!! Form::text('manager_id',Request::get('manager_id'),['class'=>'form-control','placeholder'=>'Клиент']) !!}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    {!! Form::select('status',["0"=>"Укажите статус"]+\App\Status::orderBy('sort','asc')->get(['code','title'])->lists('title','code'),Request::get('status'),['class'=>'form-control']) !!}
                </div>
            </div>
            {!! Form::hidden('filter',true) !!}
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    {!! Form::submit(Lang::get('project.filtering'),["class"=>"btn btn-primary"]) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>