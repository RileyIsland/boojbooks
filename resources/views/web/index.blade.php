<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Booj Book List</title>
</head>
<body>
<div id="app"></div>
<script>
    const bookListId = parseInt("{{ $bookListId }}");
</script>
<script src="js/app.js"></script>
</body>
</html>
