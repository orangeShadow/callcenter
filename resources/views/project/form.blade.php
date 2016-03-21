<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('sort',Lang::get('project.sort')) !!}
            {!! Form::text('sort',1000,["class"=>"form-control"])!!}
        </div>
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
            {!! Form::label('reports_type',Lang::get('project.reports_type'))!!}
            {!! Form::select('reports_type',['monthly'=>'Ежемесячно','weekly'=>'Eженедельно','daily'=>'Ежедневно'],Request::get('reports_type'),["class"=>"form-control"]) !!}
        </div>
        <div class="form-group @if($project->reports_type!='daily') hidden @endif">
            {!! Form::label('hour_start',Lang::get('project.hour_start'),['class'=>'col-lg-2 col-xs-8'])!!}
            <div class="col-lg-1 col-xs-4">{!! Form::select('hour_start',range(0,24),Request::get('hour_start'),["class"=>"form-control"]) !!}</div>
        </div>
        <div class="form-group">
            {!! Form::label('client_id',Lang::get('project.client'))!!}
            {!! Form::select('client_id',\App\User::where(['role_id'=>4])->get(['id','name'])->lists('name','id'),Request::get('client_id'),["class"=>"form-control"]) !!}
        </div>
        <div class="form-group">
            {!! Form::submit($submit,["class"=>"btn btn-primary"]) !!}
        </div>
    </div>
</div>
@section('scripts')
<script>
        $('#reports_type').change(function(e){
            e.preventDefault();
            if($(this).val()=='daily')
                $(this).parents('.form-group').next().removeClass('hidden');
            else
                $(this).parents('.form-group').next().addClass('hidden');
        });
</script>
@endsection