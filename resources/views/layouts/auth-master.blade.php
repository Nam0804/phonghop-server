<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signin</title>

    <!-- Bootstrap core CSS -->
    @vite( 'resources/js/app.js')
    {{-- <link href="{!! url('assets/css/signin.css') !!}" rel="stylesheet"> --}}

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

</head>
<body>

    <main class="form-signin container">

        @yield('content')

    </main>


</body>
</html>
