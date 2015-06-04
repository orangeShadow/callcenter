<div class="row">
    <div class="col-lg-12">
        {!! Form::hidden('key',$client->key) !!}
        <div class="form-group">
            {!! Form::label('title',Lang::get('client.title')) !!}
            {!!Form::text('title',$client->title,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('href',Lang::get('client.href')) !!}
            {!!Form::text('href',$client->href,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('sip',Lang::get('client.sip')) !!}
            {!!Form::text('sip',$client->sip,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('active',Lang::get('client.active')) !!}
            {!! Form::checkbox('active',$client->active ? $client->active:1,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::submit($submit,["class"=>"btn btn-default"]) !!}
        </div>
    </div>
</div>