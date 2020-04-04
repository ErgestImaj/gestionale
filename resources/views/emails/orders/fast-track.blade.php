<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
  <p>Gentile {{$cliente}},</p>
  <p>Il servizio di fast track è stato acquistato con successo.</p>
  <p>Numero Ordine: {{$orderNumber}}</p>
  <p>Totale: {{$orderPrice}}</p>

  <p></p>

</body>
</html>
