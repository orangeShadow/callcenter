<div class="row">
    <div class="col-lg-12">
        <div style="border:2px solid #c0c0c0;border-radius: 5px;padding:10px;">
            <h4><?=Lang::get('claim.filter')?></h4>
            {!! Form::open(['method'=>'get']) !!}
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        {!! Form::label('create_at',Lang::get('claim.createDate')) !!}
                        {!! Form::text('created_at_from',Request::get('created_at_from'),['class'=>'form-control']) !!}
                        <br>
                        {!! Form::text('created_at_to',Request::get('created_at_to'),['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        {!! Form::label('name',Lang::get('claim.contacts')) !!}
                        {!! Form::text('name',Request::get('name'),['class'=>'form-control','placeholder'=>Lang::get('claim.name')]) !!}
                        <br>
                        {!! Form::text('phone',Request::get('phone'),['class'=>'form-control','placeholder'=>Lang::get('claim.phone')]) !!}
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        {!! Form::label('status',Lang::get('claim.status')) !!}
                        {!! Form::select('status',array_merge([0=>'-'],\App\Status::orderBy('sort','asc')->get(['code','title'])->lists('title','code')),Request::get('status'),['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        {!! Form::label('id',Lang::get('claim.id')) !!}
                        {!! Form::text('id',Request::get('id'),['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        {!! Form::label('operator_id',Lang::get('claim.operator')) !!}
                        {!! Form::select('operator_id',array_merge([0=>'-'],\App\User::whereIn('role_id',[2,3])->orderBy('name','asc')->get(['id','name'])->lists('name','id')),Request::get('operator_id'),['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        {!! Form::label('project_id',Lang::get('claim.project')) !!}
                        {!! Form::select('project_id',array_merge([0=>'-'],\App\Project::orderBy('title','asc')->get(['id','title'])->lists('title','id')),Request::get('project_id'),['class'=>'form-control']) !!}
                    </div>
                </div>
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