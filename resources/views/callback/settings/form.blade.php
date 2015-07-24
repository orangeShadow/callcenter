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

        label.lh{line-height: 34px;}
    </style>
@stop
<div class="row">
    <div class="col-lg-4 col-sm-12" >
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
                        {!! Form::label('right',Lang::get('client.right')) !!}
                        {!! Form::text('right',$settings->right,["class"=>"form-control"]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
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
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Настройки автоматического показа формы
            </div>
            <div class="panel-body">
                <div class="row form-horizontal">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('sop_interval',Lang::get('client.sop_interval'),array("class"=>"col-lg-9 col-md-8 lh")) !!}
                            <div class="col-lg-3 col-md-4">{!! Form::text('sop_interval',$settings->sop_interval,["class"=>"form-control"]) !!}</div>
                        </div>

                        <div class="form-group">
                                {!! Form::label('swe_interval',Lang::get('client.swe_interval'),array("class"=>"col-lg-9 col-md-8 lh")) !!}
                                <div class="col-lg-3 col-md-4">{!! Form::text('swe_interval',$settings->swe_interval,["class"=>"form-control"]) !!}</div>
                        </div>

                        <div class="form-group">
                                {!! Form::label('site_time',Lang::get('client.site_time'),array("class"=>"col-lg-9 col-md-8 lh")) !!}
                                <div class="col-lg-3 col-md-4">{!! Form::text('site_time',$settings->site_time,["class"=>"form-control"]) !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                                {!! Form::label('client_count_show',Lang::get('client.client_count_show'),array("class"=>"col-lg-10 col-md-8 lh")) !!}
                                <div class="col-lg-2 col-md-4">{!! Form::text('client_count_show',$settings->client_count_show,["class"=>"form-control"]) !!}</div>
                        </div>

                        <div class="form-group">
                                {!! Form::label('visit_count',Lang::get('client.visit_count'),array("class"=>"col-lg-10 col-md-8 lh")) !!}
                                <div class="col-lg-2 col-md-4">{!! Form::text('visit_count',$settings->visit_count,["class"=>"form-control"]) !!}</div>
                        </div>

                        <div class="form-group">
                                {!! Form::label('page_count',Lang::get('client.page_count'),array("class"=>"col-lg-10 col-md-8 lh")) !!}
                                <div class="col-lg-2 col-md-4">{!! Form::text('page_count',$settings->page_count,["class"=>"form-control"]) !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Настройки звонков
            </div>
            <div class="panel-body">
                <div class="row form-horizontal">
                    <div class="col-lg-12">
                            {!! Form::label('defaultPhone',Lang::get('client.defaultPhone')) !!}
                            {!! Form::text('defaultPhone',$settings->defaultPhone,["class"=>"form-control"]) !!}
                    </div>
                </div>
                <div class="row form-horizontal">
                    <div class="col-lg-12">
                        <table id="phonesTable" class="table table-stripped">
                            <thead>
                                <tr><th>Дополнительные номера дозвона</th><th></th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><input id="phone" placeholder="7" class="form-control"></th><th><a id="phoneAdd" class="btn btn-primary"><i class="fa fa-plus"></i></a></th>
                                    {!! Form::hidden('phones',$settings->phones,["class"=>"form-control"]) !!}
                                </tr>
                            </tbody>
                            <tfoot>
                            @if(!empty($settings->phones))
                                @foreach(json_decode($settings->phones) as $k=>$phone)
                                    <tr><td>{{$k+1}}: {{$phone}}</td><td><a data-id="{{$k}}" class="btn btn-danger phoneDelete"><i class="fa fa-trash"></i></a></td></tr>
                                @endforeach
                            @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Голосовое приветствие роботом
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::text('textA',$settings->textA,["class"=>"form-control","placeholder"=>"Голосовое сообщению клиенту"]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::text('textB',$settings->textB,["class"=>"form-control","placeholder"=>"Голосовое сообщению вам"]) !!}
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




@section('scripts')
    <script>
    $('select#colors').change(function(){
        var color = $('select#colors').find('option[value="'+$(this).val()+'"]').html();
        $('div.colorScheme').css({'background-color':color});
    });

    $('#phoneAdd').click(function(){
        var error = false;
        var curPhone =$('#phone').val().trim();

        if ( curPhone.length == 0 )   error = true;
        if ( curPhone.length != 11 )  error = true;
        if ( !/^7/.test(curPhone))    error = true;

        if(error)
        {
            $('#phone').parent('th').addClass('has-error');
            return error;
        }

        var phones = $('input[name="phones"]').val();


        if(phones.length==0)
        {
            phones=[];
        }else{
            phones = JSON.parse(phones);
        }


        if(phones.indexOf(curPhone))
        {
            phones.push(curPhone);
        }


        var tfoot = '';
        for(var k in phones)
        {
            tfoot+='<tr><td>'+(parseInt(k)+1)+': '+phones[k]+'</td><td><a data-id="'+k+'" class="btn btn-danger phoneDelete"><i class="fa fa-trash"></i></a></td></tr>';
        }

        $('#phonesTable tfoot').html(tfoot);
        $('input[name="phones"]').val(JSON.stringify(phones));
        $('#phone').val('');
        $('#phone').parent('th').removeClass('has-error');
    });

    $(document).on('click','.phoneDelete',function(){
        var k = $(this).data('id');

        var phones = $('input[name="phones"]').val();

        //console.log(phones);

        if(phones.length==0)
        {
            phones=[];
        }else{
            phones = JSON.parse(phones);
        }

        $('input[name="phones"]').val(JSON.stringify(phones.slice(k,1)));

        $(this).parents('tr').remove();
    });
    </script>
@stop