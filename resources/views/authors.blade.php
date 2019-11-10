<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
</head>
<body>
<h1>Authors</h1>
<ul>
    @foreach($authors as $author)
        <li>{{ $author->firstname }} {{ $author->lastname }}
            <ul>
                @foreach($author->books()->get() as $book)
                    <li>{{ $book->name }}</li>
                @endforeach
            </ul>
        </li><br>
    @endforeach
</ul>
</body>
</html>
