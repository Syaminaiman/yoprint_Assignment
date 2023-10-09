<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Try</title>
    <style>
        footer{
            text-align:center;
            background:#ccc;
            position: fixed;
            bottom:0;
            height:30px;
            width:100%;
        }
    </style>
</head>
<body>
    <form action="/YoPrint" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" id="file"/>
        <p><button type="submit" name="submit">Submit</button></p>
    </form>
</body>
<footer>Copyright 2023 Syamin Aiman</footer>
</html>