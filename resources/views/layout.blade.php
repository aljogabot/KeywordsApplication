<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="css/app-all.css">
        <title>FAQ Keywords Multiplier</title>
    </head>

    <body>
        <div class="container" id="signin-container">
            @yield( 'content' )
        </div> <!-- /container -->

        @include( 'blocks/js-config' )
        <script type="text/javascript" src="{{ elixir( 'js/app-all.js' ) }}"></script>
        @section( 'modals' )@show
    </body>
</html>