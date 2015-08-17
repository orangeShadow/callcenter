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
                @if(!empty($settings->client->sip))
                {!! Form::hidden('sip',$settings->client->sip) !!}
                @endif
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
                        {!! Form::label('color_code',Lang::get('client.color_code')) !!}
                        {!! Form::text('color_code',$settings->color_code,["class"=>"form-control color"]) !!}
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
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('button_size',Lang::get('client.button_size')) !!}
                        {!! Form::text('button_size',empty($settings->button_size) ? 60:$settings->button_size,["class"=>"form-control"]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Настройки email для обращения с сайта
            </div>
            <div class="panel-body">
                <div class="row form-horizontal">
                    <div class="col-lg-12">
                        <table id="emailsTable" class="table table-stripped">
                            <tbody>
                            <tr>
                                <th><input id="email" placeholder="" class="form-control"></th><th><a id="emailAdd" class="btn btn-primary"><i class="fa fa-plus"></i></a></th>
                                {!! Form::hidden('emails',$settings->emails,["class"=>"form-control"]) !!}
                            </tr>
                            </tbody>
                            <tfoot>
                            @if(!empty($settings->emails))
                                @foreach(json_decode($settings->emails) as $k=>$email)
                                    <tr><td>{{$k+1}}: {{$email}}</td><td><a data-id="{{$k}}" class="btn btn-danger emailDelete"><i class="fa fa-trash"></i></a></td></tr>
                                @endforeach
                            @endif
                            </tfoot>
                        </table>
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
                                <div class="col-lg-3 col-md-4">{!! Form::text('site_time',empty($settings->site_time) ? null : $settings->site_time,["class"=>"form-control"]) !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                                {!! Form::label('client_count_show',Lang::get('client.client_count_show'),array("class"=>"col-lg-10 col-md-8 lh")) !!}
                                <div class="col-lg-2 col-md-4">{!! Form::text('client_count_show',empty($settings->client_count_show) ? null : $settings->client_count_show ,["class"=>"form-control"]) !!}</div>
                        </div>

                        <div class="form-group">
                                {!! Form::label('visit_count',Lang::get('client.visit_count'),array("class"=>"col-lg-10 col-md-8 lh")) !!}
                                <div class="col-lg-2 col-md-4">{!! Form::text('visit_count',empty($settings->visit_count) ? null : $settings->visit_count,["class"=>"form-control"]) !!}</div>
                        </div>

                        <div class="form-group">
                                {!! Form::label('page_count',Lang::get('client.page_count'),array("class"=>"col-lg-10 col-md-8 lh")) !!}
                                <div class="col-lg-2 col-md-4">{!! Form::text('page_count',empty($settings->page_count) ? null:$settings->page_count ,["class"=>"form-control"]) !!}</div>
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
                        {!! Form::label('record',Lang::get('client.record')) !!}
                        {!! Form::hidden('record',0) !!}
                        {!! Form::checkbox('record',1,["class"=>"form-control"]) !!}
                    </div>
                </div>
                <br>
                <div class="row form-horizontal">
                    <div class="col-lg-12">
                            {!! Form::label('defaultPhone',Lang::get('client.defaultPhone')) !!}
                            {!! Form::text('defaultPhone',$settings->defaultPhone,["class"=>"form-control"]) !!}
                    </div>
                </div>
                <br>
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
                        {!! Form::label('textA',Lang::get('client.textA')) !!}
                        @if(empty($settings->audioIdA) && empty($settings->audioFileA))
                            {!! Form::file('audioFileA') !!}
                        @else
                            {{ $settings->audioIdA }} {!! Form::submit('Удалить',["class"=>'btn btn-danger',"name"=>'delAudioA']) !!}
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        {!! Form::label('textB',Lang::get('client.textB')) !!}
                        @if(empty($settings->audioIdB) && empty($settings->audioFileB))
                            {!! Form::file('audioFileB') !!}
                        @else
                            {{ $settings->audioIdB }} {!! Form::submit('Удалить',["class"=>'btn btn-danger',"name"=>'delAudioB']) !!}
                        @endif
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
                Код для клиента:
            </div>
            <div class="panel-body">
                <span>
                   <math>
                       <![CDATA[<script src="http://{{$_SERVER["SERVER_NAME"]}}/externform?key={{$settings->client->key}}"></script>]]>
                   </math>
                </span>
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
    <script type="text/javascript" src="/js/jscolor.js"></script>
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

        if(phones.length==0)
        {
            phones=[];
        }else{
            phones = JSON.parse(phones);
        }

        phones.splice(k,1);
        $('input[name="phones"]').val(JSON.stringify(phones));

        $(this).parents('tr').remove();
    });


    $('#emailAdd').click(function(){
        var error = false;
        var curEmail =$('#email').val().trim();

        if ( !/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(curEmail))    error = true;

        if(error)
        {
            $('#email').parent('th').addClass('has-error');
            return error;
        }

        var emails = $('input[name="emails"]').val();


        if(emails.length==0)
        {
            emails=[];
        }else{
            emails = JSON.parse(emails);
        }


        if(emails.indexOf(curEmail))
        {
            emails.push(curEmail);
        }


        var tfoot = '';
        for(var k in emails)
        {
            tfoot+='<tr><td>'+(parseInt(k)+1)+': '+emails[k]+'</td><td><a data-id="'+k+'" class="btn btn-danger emailDelete"><i class="fa fa-trash"></i></a></td></tr>';
        }

        $('#emailsTable tfoot').html(tfoot);
        $('input[name="emails"]').val(JSON.stringify(emails));
        $('#email').val('');
        $('#email').parent('th').removeClass('has-error');
    });

    $(document).on('click','.emailDelete',function(){
        var k = $(this).data('id');

        var emails = $('input[name="emails"]').val();

        if(emails.length==0)
        {
            emails=[];
        }else{
            emails = JSON.parse(emails);
        }

        emails.splice(k,1);
        $('input[name="emails"]').val(JSON.stringify(emails));

        $(this).parents('tr').remove();
    });

    </script>
@stop