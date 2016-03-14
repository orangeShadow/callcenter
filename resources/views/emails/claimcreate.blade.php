<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Call-центр №1</title>
</head>
<body>
<h2>Уважаемый клиент!</h2>
<p>Зарегистрирована новая заявка № {{$claim->id}}.</p>
<p><strong>Клиент:</strong> {{$claim->name}}.</p>
<p><strong>Контактный телефон:</strong> {{$claim->phone}}.</p>
<p><strong>Описание:</strong><br>
    {{ $claim->text}}
</p>
<p>
    <strong>Дата обратного звонка:</strong> {{$claim->backcall_at}}
</p>
<p>
    <strong>Статус:</strong> {{$claim->statusT->title}}
</p>
@if(!empty($claim->typeR->title))
    <p>
        <strong>Тип обращения:</strong> {{$claim->typeR->title}}
    </p>
@endif
<p>
    <strong>Статус:</strong> {{$claim->statusT->title}}
</p>


@foreach($properties as $property)
    <p>
        <strong>{{$property["title"]}}:</strong> {!! $property["value"] !!}
    </p>
@endforeach
<p><a href="http://callcenter1.roumingu.net/claim/{{$claim->id}}">Перейти к заявке</a></p>
</body>
</html>