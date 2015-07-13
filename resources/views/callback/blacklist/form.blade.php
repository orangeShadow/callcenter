<div class="row">
    <div class="col-lg-12">
        {!! Form::hidden('user_id',Auth::user()->id) !!}
        <div class="form-group">
            {!! Form::label('phone',Lang::get('callback.phone')) !!}
            {!!Form::text('phone',$phone->phone,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::submit($submit,["class"=>"btn btn-default"]) !!}
        </div>
    </div>
</div>