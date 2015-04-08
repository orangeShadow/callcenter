<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Круглосуточный call-центр №1</title>
</head>
<body>
<h2>Уважаемый клиент!</h2>
<p>Зарегистрирована новая заявка № {{$claim->id}}.</p>
<p>Клиент: {{$claim->name}}.</p>
<p>Контактный телефон: {{$claim->phone}}.</p>
<p><a href="http://callcenter1.roumingu.net/claim/{{$claim->id}}">Перейти к заявке</a></p>
</body>
</html>