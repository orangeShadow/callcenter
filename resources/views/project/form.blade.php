<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('title',Lang::get('project.title')) !!}
            {!!Form::text('title',null,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('text',Lang::get('project.text')) !!}
            {!! Form::textarea('text',null,["class"=>"form-control"]) !!}
        </div>
        <div class="form-group">
            {!!Form::label('note',Lang::get('project.note'))!!}
            {!!Form::textarea('note',Request::get('note'),["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('status',Lang::get('project.status')) !!}
            {!! Form::select('status',\App\Status::orderBy('sort','asc')->get(['code','title'])->lists('title','code'),Request::get('status'),['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('client_id',Lang::get('project.manager'))!!}
            {!! Form::select('client_id',\App\User::where(['role_id'=>4])->get(['id','name'])->lists('name','id'),Request::get('client_id'),["class"=>"form-control"]) !!}
        </div>
        <div class="form-group">
            {!! Form::submit($submit,["class"=>"btn btn-primary"]) !!}
        </div>
    </div>
</div>