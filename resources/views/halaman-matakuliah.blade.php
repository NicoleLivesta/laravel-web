<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matakuliah</title>
</head>
<body>
    @if ($kode)
        <h1>Anda mengakses matakuliah {{ $kode }}</h1>
    @else
        <h1>Masukkan kode matakuliah!</h1>
    @endif
</body>
</html>
