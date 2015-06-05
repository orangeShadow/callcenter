<div class="row">
    <div class="col-lg-12">
        {!! Form::hidden('client_id',$settings->client_id) !!}
        <div class="form-group">
            {!! Form::label('colors',Lang::get('client.color')) !!}
            {!! Form::select('colors',[1=>1,2=>2],$settings->colors,["class"=>"form-control"]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('top',Lang::get('client.top')) !!}
            {!! Form::text('top',$settings->top,["class"=>"form-control"]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('sop_interval',Lang::get('client.sop_interval')) !!}
            {!! Form::text('sop_interval',$settings->sop_interval,["class"=>"form-control"]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('swe_interval',Lang::get('client.swe_interval')) !!}
            {!! Form::text('swe_interval',$settings->swe_interval,["class"=>"form-control"]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit($submit,["class"=>"btn btn-default"]) !!}
        </div>
    </div>
</div>