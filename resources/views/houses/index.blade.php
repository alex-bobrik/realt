<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>


<div class="container">
    <form method="post" action="{{url('/houses/search')}}">
        <div>
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputState">Rooms</label>
                <select id="inputState" class="form-control" name="roomsAmount">
                    <option selected>All</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
            <div class="form-group">
                <label for="service">Price from:</label>
                <input type="number" name="priceFrom" min="0" class="form-control" value="{{$from ?? 0}}" required>
            </div>
            <div class="form-group">
                <label for="city">Price to:</label>
                <input type="number" name="priceTo" min="0" class="form-control" value="{{$to ?? 1000}}" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Search" class="btn btn-primary" style="width: 100%">
            </div>
        </div>
    </form>

    @if(!$houses->isEmpty())
        @foreach($houses as $house)
            <div class="house">
                <img src="{{$house->image_link}}" alt="image">
                <p>Title: {{$house->title}}</p>
                <p>Description: {{$house->description}}</p>
                <p>Price: {{$house->price_per_day}} r/d</p>
            </div>
        @endforeach
    @else
        <p>no houses for ur search</p>
    @endif


{{--{{$houses->withQueryString()->links()}}--}}

</div>

</body>
</html>
