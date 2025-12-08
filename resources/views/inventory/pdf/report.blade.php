<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>

    <style>

        @page {
            margin: 0;
            size: A4;
        }

    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <h1 class="text-secondary text-center">Inventory Report</h1>
    <p class="small text-center text-secondary">Date: {{$date->format('Y-m-d')}}</p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Stock</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->stock}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>