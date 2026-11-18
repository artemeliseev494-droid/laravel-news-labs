<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Новостной сайт')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0 20px;
            background: #ffffff;
            color: #222222;
        }
        a {
            color: #0366d6;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }
        table, th, td {
            border: 1px solid #cccccc;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .msg-success {
            background-color: #e6ffed;
            color: #22863a;
            padding: 10px 15px;
            border: 1px solid #bef5cb;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .msg-error {
            background-color: #ffeef0;
            color: #cb2431;
            padding: 10px 15px;
            border: 1px solid #fdaeb7;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            max-width: 500px;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }
        button, input[type="submit"] {
            padding: 7px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .article-item {
            border: 1px solid #e1e4e8;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            background-color: #fafbfc;
        }
        .article-item h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }
        .article-meta {
            font-size: 13px;
            color: #586069;
            margin-bottom: 10px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 12px;
            border-radius: 3px;
            background-color: #e1e4e8;
            color: #24292e;
        }
        .badge-blocked {
            background-color: #ffdce0;
            color: #86181d;
        }
        .badge-active {
            background-color: #dcffe4;
            color: #165c26;
        }
    </style>
</head>
<body>

    <x-header />

    <main>
        @if(session('success'))
            <div class="msg-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="msg-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="msg-error">
                <strong>Пожалуйста, исправьте ошибки:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <x-footer />

</body>
</html>
