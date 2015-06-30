@section('css')
    <style>
        .colorList{
            display:block;
            margin: 10px 0;
        }

        p.color{
            display: inline-block;
            width:30px;
            height:30px;
            margin:5px;
            cursor: pointer;
        }

        p.color:hover{
            border: 2px solid #FF4F00;
        }
        p.color.active{
            border: 2px solid #000;
        }
        div.setting-submit{
            margin-left: 15px;;
        }
    </style>
@stop
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Настройка отображения
            </div>
            <div class="panel-body">
                {!! Form::hidden('client_id',$settings->client_id) !!}
                <div class="form-group">
                    <div class="col-lg-12">
                    {!! Form::label('colors',Lang::get('client.color')) !!}
                    {!! Form::hidden('colors',$settings->color,["class"=>"form-control"]) !!}
                    <div class = "colorList" >
                        @foreach(App()->CallbackHelper->getColors()  as $key=>$color)
                            <p data-color="{{$key}}" style="background-color:{{$color}}" class="color @if($key==$settings->colors) active @endif"></p>
                        @endforeach
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('top',Lang::get('client.top')) !!}
                        {!! Form::text('top',$settings->top,["class"=>"form-control"]) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('sop_interval',Lang::get('client.sop_interval')) !!}
                        {!! Form::text('sop_interval',$settings->sop_interval,["class"=>"form-control"]) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('swe_interval',Lang::get('client.swe_interval')) !!}
                        {!! Form::text('swe_interval',$settings->swe_interval,["class"=>"form-control"]) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Настройка WEB аналитики
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('yandex_cn',Lang::get('client.yandex_cn')) !!}
                        {!! Form::text('yandex_cn',$settings->yandex_cn,["class"=>"form-control"]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('yandex_goal',Lang::get('client.yandex_goal')) !!}
                        {!! Form::text('yandex_goal',$settings->yandex_goal,["class"=>"form-control"]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <div class="setting-submit">
                {!! Form::submit($submit,["class"=>"btn btn-success"]) !!}
            </div>
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