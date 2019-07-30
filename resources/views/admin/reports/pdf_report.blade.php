<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Opens</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <img src={{ asset('img/opens-logo.png') }} alt="">
    <p class="text-justify">Naziv projekta: {{ $project->organization->name }}</p>
    <p class="text-justify">Naziv : {{ $project->title }}</p>
    

    <table class="table">
        <thead>
          <tr>
            <th>Stavka</th>
            <th>Datum plaćanja</th>
            <th>Broj izvoda</th>
            <th>Planirano</th>
            <th>Potrošeno</th>
            <th>Preostala sredstva</th>
            <th>Ukupno potrošeno %</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($project->categories as $category)
                <tr scope="row">
                    <td>{{ $category->name }}</td>  
                </tr>
                @foreach ($category->costs as $cost)
                    <tr>
                        <td>{{ $cost->description }}</td>
                        <td>{{ !empty($cost->payment_date) ? date("d-m-Y", strtotime($cost->payment_date)) : '' }}</td>
                        <td>{{ $cost->invoice_number }}</td>
                        <td></td>
                        <td>{{ number_format($cost->spent_donator, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total:</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($category->approved_for_category, 2) }}</td>
                    <td>{{ number_format($category->costs->sum('spent_private'), 2) }}</td>
                    <td>{{ number_format($category->approved_for_category - $category->costs->sum('spent_private'), 2) }}</td>
                    <td>{{ !empty($category->approved_for_category) && isset($category->approved_for_category) ? round($category->costs->sum('spent_private')
                            * 100 / $category->approved_for_category, 2) : '' }} %</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>