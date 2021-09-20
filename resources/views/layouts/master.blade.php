<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home - Start Bootstrap Template</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="/css/blog-home.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    @include('Layouts.header')

    <!-- Page Content -->
    <div class="container">


        <!-- /.row -->
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                @yield('content')

            </div>

            <!-- Sidebar Widgets Column -->
@include('Layouts.sidebar')

        </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    @include('Layouts.footer')

    <!-- Bootstrap core JavaScript -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>