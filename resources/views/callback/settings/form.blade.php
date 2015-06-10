<div class="row">
    <div class="col-lg-12">
        {!! Form::hidden('client_id',$settings->client_id) !!}
        <div class="form-group">
            {!! Form::label('colors',Lang::get('client.color')) !!}
            {!! Form::select('colors',App\ACME\Helpers\CallbackHelper::$colors,["class"=>"form-control"]) !!}
            <div style="width:30px;height:30px;margin:5px;background-color:<?=App\ACME\Helpers\CallbackHelper::$colors[empty($settings->colors)?1:$settings->colors]?>" class="colorScheme"></div>
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

@section('sripts')
    <script>
    $('select#colors').change(function(){
        var color = $('select#colors').find('option[value="'+$(this).val()+'"]').html();
        console.log(color);
        $('div.colorScheme').css({'background-color':color});
    })
    </script>
@stop