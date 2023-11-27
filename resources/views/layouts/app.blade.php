<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Store</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color:white;
            font-weight: bold;
            background-color: #2d3748;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
        h2{
            text-align: center;
        }
        .container {
            color: white;
            font-weight: bold;
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
            background-color: #2d3748;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .routes-buttons{
            text-align: right;
            font-size: 25px;
            text-decoration: none;
            color: white;
        }
        .btn {
            display: inline-block;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger {
            margin-top: 10px;
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

    </style>
</head>
<body>
<header>
    <h1>Pet Store</h1>
</header>

<div class="container">
    @yield('content')
</div>
</body>
</html>
