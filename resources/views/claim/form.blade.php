<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('project_id',Lang::get('claim.project'))!!}
            {!! Form::select('project_id',array_merge(['-'=>'-'],\App\Project::where("status","<>","Z")->get(["id","title"])->lists('title','id')),Request::get('project_id'),['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('name',Lang::get('claim.name')) !!}
            {!!Form::text('name',null,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('phone',Lang::get('claim.phone')) !!}
            {!!Form::text('phone',null,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('text',Lang::get('claim.text')) !!}
            {!! Form::textarea('text',null,["class"=>"form-control"]) !!}
        </div>
        <div class="form-group">
            {!!Form::label('note',Lang::get('claim.note'))!!}
            {!!Form::textarea('note',Request::get('note'),["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('status',Lang::get('claim.status')) !!}
            {!! Form::select('status',\App\StatusClaim::orderBy('sort','asc')->get(['code','title'])->lists('title','code'),Request::get('status'),['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Создать',["class"=>"btn btn-default"]) !!}
        </div>
    </div>
</div>