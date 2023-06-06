<!doctype html>
<html lang="en">
<head>
    <title>Check24 Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
        .single-post, .single-post-detail {
            background-color: lightblue;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .comment-form {
            background-color: lightblue;
            padding-bottom: 20px;
            padding-top: 20px;
            margin-bottom: 10px;
        }

        .menu li {
            float: left;
            list-style-type: none;
            padding: 10px;
        }

        .menu {
            width: 100%;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        @include('partials.logo')
        @include('partials.nav')
        @include('partials.flash-messages')

        @yield('content')
    </div>
</div>
</body>
</html>