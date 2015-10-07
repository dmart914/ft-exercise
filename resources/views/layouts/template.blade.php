<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Laravel test</title>
        <link rel="stylesheet" href="{{ asset('css/foundation.css') }}" />
        <script src="{{ asset('js/vendor/modernizr.js') }}"></script>
    </head>
    <body>

        <!-- Header and nav -->

        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <li class="name">
                    <h1><a href="/ft/index.php">Dave's Real Estate Holdings</a></h1>
                </li>
            </ul>
            <section class="top-bar-section">
                <ul class="right">
                    <li class="divider"></li>
                    <li><a href="/ft/index.php/search">Search</a></li>
                </ul>
            </section>
        </nav>
        @if (Session::has('message'))
            <div class="alert-box success">{{{ Session::get('message') }}}</div>

        @endif
        <!-- End header and nav -->

        <div class="row">
            <div class="large-12">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->

        <footer class="row">
            <div class="large-12 columns">
                <hr />
                <div class="row">
                    <div class="large-6 columns">
                        <p>c Dave</p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/vendor/jquery.js') }}"></script>
        <script src="{{ asset('js/foundation.min.js') }}"></script>
        <script>
            $(document).foundation();
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
